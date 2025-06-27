<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class ProjectDocumentController extends Controller
{
    /**
     * Генерирует документ для скачивания
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function generateDocument(Request $request, Project $project)
    {
        $request->validate([
            'document_type' => 'required|string',
            'format' => 'required|in:pdf,docx',
            'include_signature' => 'nullable|boolean',
            'include_stamp' => 'nullable|boolean',
        ]);
        
        $documentType = $request->document_type;
        $format = $request->format;
        $includeSignature = $request->include_signature ?? false;
        $includeStamp = $request->include_stamp ?? false;
        
        $user = Auth::user();
        $partner = $user->role === 'admin' ? $project->partner : $user;
        
        if (!$partner) {
            return response()->json(['error' => 'Партнер не найден'], 404);
        }
        
        switch ($documentType) {
            case 'completion_act_ip_ip':
                return $this->generateCompletionActIpIp($project, $partner, $format, $includeSignature, $includeStamp);
            case 'completion_act_fl_ip':
                return $this->generateCompletionActFlIp($project, $partner, $format, $includeSignature, $includeStamp);
            case 'act_ip_ip':
                return $this->generateActIpIp($project, $partner, $format, $includeSignature, $includeStamp);
            case 'act_fl_ip':
                return $this->generateActFlIp($project, $partner, $format, $includeSignature, $includeStamp);
            case 'bso':
                return $this->generateBso($project, $partner, $format, $includeSignature, $includeStamp);
            case 'invoice_ip':
                return $this->generateInvoiceIp($project, $partner, $format, $includeSignature, $includeStamp);
            case 'invoice_fl':
                return $this->generateInvoiceFl($project, $partner, $format, $includeSignature, $includeStamp);
            default:
                return response()->json(['error' => 'Неизвестный тип документа'], 400);
        }
    }
    
    /**
     * Генерирует предпросмотр документа
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function previewDocument(Request $request, Project $project)
    {
        $request->validate([
            'document_type' => 'required|string',
            'include_signature' => 'nullable|boolean',
            'include_stamp' => 'nullable|boolean',
        ]);
        
        // Возвращаем HTML содержимое документа для предпросмотра
        $documentType = $request->document_type;
        $includeSignature = $request->include_signature ?? false;
        $includeStamp = $request->include_stamp ?? false;
        
        $user = Auth::user();
        $partner = $user->role === 'admin' ? $project->partner : $user;
        
        if (!$partner) {
            return response()->json(['error' => 'Партнер не найден'], 404);
        }
        
        $html = '';
        
        switch ($documentType) {
            case 'completion_act_ip_ip':
                $html = $this->getCompletionActIpIpHtml($project, $partner, $includeSignature, $includeStamp);
                break;
            case 'completion_act_fl_ip':
                $html = $this->getCompletionActFlIpHtml($project, $partner, $includeSignature, $includeStamp);
                break;
            case 'act_ip_ip':
                $html = $this->getActIpIpHtml($project, $partner, $includeSignature, $includeStamp);
                break;
            case 'act_fl_ip':
                $html = $this->getActFlIpHtml($project, $partner, $includeSignature, $includeStamp);
                break;
            case 'bso':
                $html = $this->getBsoHtml($project, $partner, $includeSignature, $includeStamp);
                break;
            case 'invoice_ip':
                $html = $this->getInvoiceIpHtml($project, $partner, $includeSignature, $includeStamp);
                break;
            case 'invoice_fl':
                $html = $this->getInvoiceFlHtml($project, $partner, $includeSignature, $includeStamp);
                break;
            default:
                return response()->json(['error' => 'Неизвестный тип документа'], 400);
        }
        
        return response()->json(['html' => $html]);
    }

    /**
     * Генерирует акт завершения ремонта между ИП и ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  string  $format
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return \Illuminate\Http\Response
     */
    private function generateCompletionActIpIp($project, $partner, $format, $includeSignature, $includeStamp)
    {
        $html = $this->getCompletionActIpIpHtml($project, $partner, $includeSignature, $includeStamp);
        
        if ($format === 'pdf') {
            return $this->generatePdf($html, 'Акт_завершения_ремонта_ИП-ИП_' . $project->id);
        } else {
            return $this->generateDocx($html, 'Акт_завершения_ремонта_ИП-ИП_' . $project->id);
        }
    }
    
    /**
     * Возвращает HTML для акта завершения ремонта между ИП и ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return string
     */
    private function getCompletionActIpIpHtml($project, $partner, $includeSignature, $includeStamp)
    {
        $now = Carbon::now();
        $formattedDateTime = $now->format('d.m.Y, H:i');
        $actNumber = $now->format('Ymd') . '-' . rand(10000, 99999);
        
        $signatureHtml = '';
        if ($includeSignature && $partner->signature_file) {
            $signatureHtml = '<img src="' . $partner->getSignatureUrl() . '" style="height: 50px; max-width: 150px;">';
        }
        
        $stampHtml = '';
        if ($includeStamp && $partner->stamp_file) {
            $stampHtml = '<img src="' . $partner->getStampUrl() . '" style="height: 100px; max-width: 100px; position: absolute; margin-left: 20px; margin-top: -60px; opacity: 0.7;">';
        }
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Акт об оказании услуг</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12pt;
                    line-height: 1.5;
                }
                h1 {
                    font-size: 16pt;
                    text-align: center;
                    font-weight: bold;
                    margin-bottom: 10px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .date {
                    text-align: right;
                    margin-bottom: 20px;
                }
                .content {
                    margin-bottom: 30px;
                }
                .signatures {
                    width: 100%;
                    margin-top: 40px;
                }
                .signature-table {
                    width: 100%;
                    border-collapse: collapse;
                }
                .signature-table td {
                    width: 50%;
                    vertical-align: top;
                    padding: 10px;
                }
                .signature-line {
                    margin-top: 50px;
                    position: relative;
                }
                .signature-block {
                    text-align: center;
                }
                .center {
                    text-align: center;
                }
                .spacer {
                    margin-top: 20px;
                }
                p {
                    margin: 10px 0;
                }
                ol {
                    margin-left: 20px;
                }
                li {
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <h1>АКТ</h1>
            <p class="center">об оказании услуг</p>
            <p class="center">к Договору № ' . ($project->contract_number ?: 'б/н') . ' от ' . ($project->contract_date ? $project->contract_date->format('d.m.Y') : $now->format('d.m.Y')) . '</p>
            
            <div class="spacer"></div>
            
            <div class="date">г. ' . ($project->city ?: 'Москва') . '</div>
            <div class="date">' . $formattedDateTime . '</div>
            
            <div class="spacer"></div>
            
            <div class="content">
                <p>Мы, нижеподписавшиеся,</p>
                
                <p>' . ($partner->name ?: '') . ', именуемый в дальнейшем «Подрядчик», в лице руководителя ' . ($partner->name ?: '') . ', с одной стороны,</p>
                
                <p>и ' . ($project->client_name ?: '') . ', именуемый в дальнейшем «Заказчик», в лице «' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '» , с другой стороны,</p>
                
                <p>вместе именуемые «Стороны», подтверждаем, что:</p>
                
                <ol>
                    <li>Все взаимные обязательства по ремонтно-строительным работам в рамках Договора № ' . ($project->contract_number ?: 'б/н') . ' от ' . ($project->contract_date ? $project->contract_date->format('d.m.Y') : $now->format('d.m.Y')) . ' выполнены полностью.</li>
                    <li>«Заказчик» по объему, качеству и срокам оказания услуг претензий не имеет.</li>
                    <li>Гарантийное обслуживание предоставляется в соответствии с условиями договора.</li>
                    <li>Данный Акт приема-передачи составлен в 2 (двух) экземплярах, идентичных по своему содержанию, один из которых передается «Заказчику», другой – «Подрядчику».</li>
                    <li>Подписи сторон:</li>
                </ol>
            </div>
            
            <table class="signature-table">
                <tr>
                    <td><strong>ПОДРЯДЧИК</strong></td>
                    <td><strong>ЗАКАЗЧИК</strong></td>
                </tr>
                <tr>
                    <td>
                        <div class="signature-line">
                            <p>_____________________</p>
                            <p>Подпись</p>
                            
                            <div class="signature-block">' . $signatureHtml . '</div>
                            <div class="signature-block">' . $stampHtml . '</div>
                        </div>
                    </td>
                    <td>
                        <div class="signature-line">
                            <p>_____________________</p>
                            <p>Подпись</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>' . ($partner->name ?: '') . '</p>
                        <p>Расшифровка подписи</p>
                    </td>
                    <td>
                        <p>' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '</p>
                        <p>Расшифровка подписи</p>
                    </td>
                </tr>
            </table>
        </body>
        </html>';
        
        return $html;
    }

    /**
     * Генерирует акт завершения ремонта между ФЛ и ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  string  $format
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return \Illuminate\Http\Response
     */
    private function generateCompletionActFlIp($project, $partner, $format, $includeSignature, $includeStamp)
    {
        $html = $this->getCompletionActFlIpHtml($project, $partner, $includeSignature, $includeStamp);
        
        if ($format === 'pdf') {
            return $this->generatePdf($html, 'Акт_завершения_ремонта_ФЛ-ИП_' . $project->id);
        } else {
            return $this->generateDocx($html, 'Акт_завершения_ремонта_ФЛ-ИП_' . $project->id);
        }
    }
    
    /**
     * Возвращает HTML для акта завершения ремонта между ФЛ и ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return string
     */
    private function getCompletionActFlIpHtml($project, $partner, $includeSignature, $includeStamp)
    {
        $now = Carbon::now();
        $formattedDateTime = $now->format('d.m.Y, H:i');
        
        $signatureHtml = '';
        if ($includeSignature && $partner->signature_file) {
            $signatureHtml = '<img src="' . $partner->getSignatureUrl() . '" style="height: 50px; max-width: 150px;">';
        }
        
        $stampHtml = '';
        if ($includeStamp && $partner->stamp_file) {
            $stampHtml = '<img src="' . $partner->getStampUrl() . '" style="height: 100px; max-width: 100px; position: absolute; margin-left: 20px; margin-top: -60px; opacity: 0.7;">';
        }
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Акт об оказании услуг</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12pt;
                    line-height: 1.5;
                }
                h1 {
                    font-size: 16pt;
                    text-align: center;
                    font-weight: bold;
                    margin-bottom: 10px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .date {
                    text-align: right;
                    margin-bottom: 20px;
                }
                .content {
                    margin-bottom: 30px;
                }
                .signatures {
                    width: 100%;
                    margin-top: 40px;
                }
                .signature-table {
                    width: 100%;
                    border-collapse: collapse;
                }
                .signature-table td {
                    width: 50%;
                    vertical-align: top;
                    padding: 10px;
                }
                .signature-line {
                    margin-top: 50px;
                    position: relative;
                }
                .signature-block {
                    text-align: center;
                }
                .center {
                    text-align: center;
                }
                .spacer {
                    margin-top: 20px;
                }
                p {
                    margin: 10px 0;
                }
                ol {
                    margin-left: 20px;
                }
                li {
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <h1>АКТ</h1>
            <p class="center">об оказании услуг</p>
            <p class="center">к Договору № ' . ($project->contract_number ?: 'б/н') . ' от ' . ($project->contract_date ? $project->contract_date->format('d.m.Y') : $now->format('d.m.Y')) . '</p>
            
            <div class="spacer"></div>
            
            <div class="date">г. ' . ($project->city ?: 'Москва') . '</div>
            <div class="date">' . $formattedDateTime . '</div>
            
            <div class="spacer"></div>
            
            <div class="content">
                <p>Мы, нижеподписавшиеся,</p>
                
                <p>' . ($partner->name ?: '') . ', именуемый в дальнейшем «Подрядчик», в лице руководителя ' . ($partner->name ?: '') . ', с одной стороны,</p>
                
                <p>и ' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . ', именуемый в дальнейшем «Заказчик», в лице «' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '» , с другой стороны,</p>
                
                <p>вместе именуемые «Стороны», подтверждаем, что:</p>
                
                <ol>
                    <li>Все взаимные обязательства по ремонтно-строительным работам в рамках Договора № ' . ($project->contract_number ?: 'б/н') . ' от ' . ($project->contract_date ? $project->contract_date->format('d.m.Y') : $now->format('d.m.Y')) . ' выполнены полностью.</li>
                    <li>«Заказчик» по объему, качеству и срокам оказания услуг претензий не имеет.</li>
                    <li>Гарантийное обслуживание предоставляется в соответствии с условиями договора.</li>
                    <li>Данный Акт приема-передачи составлен в 2 (двух) экземплярах, идентичных по своему содержанию, один из которых передается «Заказчику», другой – «Подрядчику».</li>
                    <li>Подписи сторон:</li>
                </ol>
            </div>
            
            <table class="signature-table">
                <tr>
                    <td><strong>ПОДРЯДЧИК</strong></td>
                    <td><strong>ЗАКАЗЧИК</strong></td>
                </tr>
                <tr>
                    <td>
                        <div class="signature-line">
                            <p>_____________________</p>
                            <p>Подпись</p>
                            
                            <div class="signature-block">' . $signatureHtml . '</div>
                            <div class="signature-block">' . $stampHtml . '</div>
                        </div>
                    </td>
                    <td>
                        <div class="signature-line">
                            <p>_____________________</p>
                            <p>Подпись</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>' . ($partner->name ?: '') . '</p>
                        <p>Расшифровка подписи</p>
                    </td>
                    <td>
                        <p>' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '</p>
                        <p>Расшифровка подписи</p>
                    </td>
                </tr>
            </table>
        </body>
        </html>';
        
        return $html;
    }

    /**
     * Генерирует акт выполненных работ между ИП и ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  string  $format
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return \Illuminate\Http\Response
     */
    private function generateActIpIp($project, $partner, $format, $includeSignature, $includeStamp) {
        $html = $this->getActIpIpHtml($project, $partner, $includeSignature, $includeStamp);
        
        if ($format === 'pdf') {
            return $this->generatePdf($html, 'Акт_выполненных_работ_ИП-ИП_' . $project->id);
        } else {
            return $this->generateDocx($html, 'Акт_выполненных_работ_ИП-ИП_' . $project->id);
        }
    }
    
    /**
     * Возвращает HTML для акта выполненных работ между ИП и ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return string
     */
    private function getActIpIpHtml($project, $partner, $includeSignature, $includeStamp) {
        $now = Carbon::now();
        $formattedDateTime = $now->format('d.m.Y, H:i');
        $actNumber = $now->format('Ymd') . '-' . rand(10000, 99999);
        
        $signatureHtml = '';
        if ($includeSignature && $partner->signature_file) {
            $signatureHtml = '<img src="' . $partner->getSignatureUrl() . '" style="height: 50px; max-width: 150px;">';
        }
        
        $stampHtml = '';
        if ($includeStamp && $partner->stamp_file) {
            $stampHtml = '<img src="' . $partner->getStampUrl() . '" style="height: 100px; max-width: 100px; position: absolute; margin-left: 20px; margin-top: -60px; opacity: 0.7;">';
        }
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Акт о приемке выполненных работ</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12pt;
                    line-height: 1.5;
                }
                h1 {
                    font-size: 16pt;
                    text-align: center;
                    font-weight: bold;
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }
                .center {
                    text-align: center;
                }
                .right {
                    text-align: right;
                }
                .header {
                    margin-bottom: 20px;
                }
                .date {
                    text-align: right;
                    margin-bottom: 20px;
                }
                .content {
                    margin-bottom: 30px;
                }
                .signatures {
                    margin-top: 40px;
                }
                .signature-table {
                    width: 100%;
                    border-collapse: collapse;
                    border: none;
                }
                .signature-table td {
                    width: 50%;
                    vertical-align: top;
                    padding: 10px;
                    border: none;
                }
                .signature-line {
                    margin-top: 50px;
                    position: relative;
                }
                .spacer {
                    margin-top: 20px;
                }
                .no-border {
                    border: none;
                }
            </style>
        </head>
        <body>
            <h1>Акт о приемке выполненных работ № ' . $actNumber . '</h1>
            <div class="date">от ' . $formattedDateTime . '</div>
            
            <div class="content">
                <p><strong>Подрядчик</strong> ' . ($partner->name ?: 'наименование организации') . '</p>
                <p><strong>В лице</strong> ' . ($partner->name ?: 'должность, ФИО ответственного лица') . '</p>
                
                <p><strong>С одной стороны, и Заказчик</strong> ' . ($project->client_name ?: 'наименование организации') . '</p>
                <p><strong>В лице</strong> «' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '»</p>
                <p>с другой стороны, составили настоящий акт о том, что в соответствии с Договором подряда № ' . ($project->contract_number ?: 'б/н') . ' от ' . ($project->contract_date ? $project->contract_date->format('d.m.Y') : $now->format('d.m.Y')) . '</p>
                <p>Подрядчиком были выполнены следующие работы (оказаны следующие услуги):</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Выполненные работы</th>
                        <th>Ед.</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ремонтно-строительные работы</td>
                        <td>усл.</td>
                        <td>1</td>
                        <td class="right">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                        <td class="right">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="right no-border"><strong>НДС не облагается</strong></td>
                        <td class="right"></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="right no-border"><strong>Всего к оплате:</strong></td>
                        <td class="right">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                    </tr>
                </tfoot>
            </table>
            
            <p><strong>Всего оказано услуг на сумму:</strong> ' . $this->num2str($project->total_amount) . '</p>
            
            <p>Вышеперечисленные работы (услуги) выполнены полностью и в срок. Заказчик претензий по объему, качеству и срокам оказания услуг претензий не имеет.</p>
            
            <table class="signature-table">
                <tr>
                    <td class="no-border"><strong>ПОДРЯДЧИК</strong></td>
                    <td class="no-border"><strong>ЗАКАЗЧИК</strong></td>
                </tr>
                <tr>
                    <td class="no-border">
                        <div class="signature-line">
                            <p>_____________________</p>
                            <p>Подпись</p>
                            
                            <div class="signature-block">' . $signatureHtml . '</div>
                            <div class="signature-block">' . $stampHtml . '</div>
                        </div>
                    </td>
                    <td class="no-border">
                        <div class="signature-line">
                            <p>_____________________</p>
                            <p>Подпись</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="no-border">
                        <p>' . ($partner->name ?: '') . '</p>
                        <p>Расшифровка подписи</p>
                    </td>
                    <td class="no-border">
                        <p>' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '</p>
                        <p>Расшифровка подписи</p>
                    </td>
                </tr>
            </table>
        </body>
        </html>';
        
        return $html;
    }

    /**
     * Генерирует акт выполненных работ между ФЛ и ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  string  $format
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return \Illuminate\Http\Response
     */
    private function generateActFlIp($project, $partner, $format, $includeSignature, $includeStamp) {
        $html = $this->getActFlIpHtml($project, $partner, $includeSignature, $includeStamp);
        
        if ($format === 'pdf') {
            return $this->generatePdf($html, 'Акт_выполненных_работ_ФЛ-ИП_' . $project->id);
        } else {
            return $this->generateDocx($html, 'Акт_выполненных_работ_ФЛ-ИП_' . $project->id);
        }
    }
    
    /**
     * Возвращает HTML для акта выполненных работ между ФЛ и ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return string
     */
    private function getActFlIpHtml($project, $partner, $includeSignature, $includeStamp) {
        $now = Carbon::now();
        $formattedDateTime = $now->format('d.m.Y, H:i');
        $actNumber = $now->format('Ymd') . '-' . rand(10000, 99999);
        
        $signatureHtml = '';
        if ($includeSignature && $partner->signature_file) {
            $signatureHtml = '<img src="' . $partner->getSignatureUrl() . '" style="height: 50px; max-width: 150px;">';
        }
        
        $stampHtml = '';
        if ($includeStamp && $partner->stamp_file) {
            $stampHtml = '<img src="' . $partner->getStampUrl() . '" style="height: 100px; max-width: 100px; position: absolute; margin-left: 20px; margin-top: -60px; opacity: 0.7;">';
        }
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Акт о приемке выполненных работ</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12pt;
                    line-height: 1.5;
                }
                h1 {
                    font-size: 16pt;
                    text-align: center;
                    font-weight: bold;
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }
                .center {
                    text-align: center;
                }
                .right {
                    text-align: right;
                }
                .header {
                    margin-bottom: 20px;
                }
                .date {
                    text-align: right;
                    margin-bottom: 20px;
                }
                .content {
                    margin-bottom: 30px;
                }
                .signatures {
                    margin-top: 40px;
                }
                .signature-table {
                    width: 100%;
                    border-collapse: collapse;
                    border: none;
                }
                .signature-table td {
                    width: 50%;
                    vertical-align: top;
                    padding: 10px;
                    border: none;
                }
                .signature-line {
                    margin-top: 50px;
                    position: relative;
                }
                .spacer {
                    margin-top: 20px;
                }
                .no-border {
                    border: none;
                }
            </style>
        </head>
        <body>
            <h1>Акт о приемке выполненных работ № ' . $actNumber . '</h1>
            <div class="date">от ' . $formattedDateTime . '</div>
            
            <div class="content">
                <p><strong>Подрядчик</strong> ' . ($partner->name ?: 'наименование организации') . '</p>
                <p><strong>В лице</strong> ' . ($partner->name ?: 'должность, ФИО ответственного лица') . '</p>
                
                <p><strong>С одной стороны, и Заказчик</strong> Физическое лицо</p>
                <p><strong>В лице</strong> «' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '»</p>
                <p>с другой стороны, составили настоящий акт о том, что в соответствии с Договором подряда № ' . ($project->contract_number ?: 'б/н') . ' от ' . ($project->contract_date ? $project->contract_date->format('d.m.Y') : $now->format('d.m.Y')) . '</p>
                <p>Подрядчиком были выполнены следующие работы (оказаны следующие услуги):</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Выполненные работы</th>
                        <th>Ед.</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ремонтно-строительные работы</td>
                        <td>усл.</td>
                        <td>1</td>
                        <td class="right">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                        <td class="right">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="right no-border"><strong>НДС не облагается</strong></td>
                        <td class="right"></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="right no-border"><strong>Всего к оплате:</strong></td>
                        <td class="right">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                    </tr>
                </tfoot>
            </table>
            
            <p><strong>Всего оказано услуг на сумму:</strong> ' . $this->num2str($project->total_amount) . '</p>
            
            <p>Вышеперечисленные работы (услуги) выполнены полностью и в срок. Заказчик претензий по объему, качеству и срокам оказания услуг претензий не имеет.</p>
            
            <table class="signature-table">
                <tr>
                    <td class="no-border"><strong>ПОДРЯДЧИК</strong></td>
                    <td class="no-border"><strong>ЗАКАЗЧИК</strong></td>
                </tr>
                <tr>
                    <td class="no-border">
                        <div class="signature-line">
                            <p>_____________________</p>
                            <p>Подпись</p>
                            
                            <div class="signature-block">' . $signatureHtml . '</div>
                            <div class="signature-block">' . $stampHtml . '</div>
                        </div>
                    </td>
                    <td class="no-border">
                        <div class="signature-line">
                            <p>_____________________</p>
                            <p>Подпись</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="no-border">
                        <p>' . ($partner->name ?: '') . '</p>
                        <p>Расшифровка подписи</p>
                    </td>
                    <td class="no-border">
                        <p>' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '</p>
                        <p>Расшифровка подписи</p>
                    </td>
                </tr>
            </table>
        </body>
        </html>';
        
        return $html;
    }

    /**
     * Генерирует БСО
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  string  $format
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return \Illuminate\Http\Response
     */
    private function generateBso($project, $partner, $format, $includeSignature, $includeStamp) {
        $html = $this->getBsoHtml($project, $partner, $includeSignature, $includeStamp);
        
        if ($format === 'pdf') {
            return $this->generatePdf($html, 'БСО_' . $project->id);
        } else {
            return $this->generateDocx($html, 'БСО_' . $project->id);
        }
    }
    
    /**
     * Возвращает HTML для БСО
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return string
     */
    private function getBsoHtml($project, $partner, $includeSignature, $includeStamp) {
        $now = Carbon::now();
        
        $signatureHtml = '';
        if ($includeSignature && $partner->signature_file) {
            $signatureHtml = '<img src="' . $partner->getSignatureUrl() . '" style="height: 50px; max-width: 150px;">';
        }
        
        $stampHtml = '';
        if ($includeStamp && $partner->stamp_file) {
            $stampHtml = '<img src="' . $partner->getStampUrl() . '" style="height: 100px; max-width: 100px; position: absolute; margin-left: 20px; margin-top: -60px; opacity: 0.7;">';
        }
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta charset="UTF-8">
            <title>БСО</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12pt;
                }
                .container {
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .date {
                    text-align: right;
                    margin-bottom: 20px;
                }
                .section {
                    margin-bottom: 20px;
                }
                .signature {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 50px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>БЛАНК СТРОГОЙ ОТЧЕТНОСТИ</h2>
                    <div class="date">от ' . $now->format('d.m.Y') . ' г.</div>
                </div>
                
                <div class="section">
                    <p><strong>Исполнитель:</strong> ИП ' . $partner->name . '</p>
                    <p><strong>ИНН:</strong> ' . ($partner->inn ?: '_________') . '</p>
                    <p><strong>ОГРНИП:</strong> ' . ($partner->ogrnip ?: '_________') . '</p>
                    <p><strong>Адрес:</strong> ' . ($partner->address ?: 'не указан') . '</p>
                </div>
                
                <div class="section">
                    <p><strong>Заказчик:</strong> ' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '</p>
                    <p><strong>Адрес:</strong> ' . ($project->address ?: 'не указан') . '</p>
                    <p><strong>По договору №</strong> ' . ($project->contract_number ?: 'б/н') . ' от ' . ($project->contract_date ? $project->contract_date->format('d.m.Y') : $now->format('d.m.Y')) . '</p>
                </div>
                
                <div class="section">
                    <p><strong>Наименование услуг:</strong> Ремонтно-строительные работы</p>
                    <p><strong>Сумма, руб:</strong> ' . number_format($project->total_amount, 2, ',', ' ') . '</p>
                    <p><strong>Без НДС</strong></p>
                </div>
                
                <div class="signature">
                    <div>
                        <p>Исполнитель:</p>
                        <div class="signature">' . $signatureHtml . '</div>
                        <div class="stamp">' . $stampHtml . '</div>
                    </div>
                    <div>
                        <p>Заказчик:</p>
                        <p>______________</p>
                    </div>
                </div>
            </div>
        </body>
        </html>';
        
        return $html;
    }

    /**
     * Генерирует счет для ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  string  $format
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return \Illuminate\Http\Response
     */
    private function generateInvoiceIp($project, $partner, $format, $includeSignature, $includeStamp) {
        $html = $this->getInvoiceIpHtml($project, $partner, $includeSignature, $includeStamp);
        
        if ($format === 'pdf') {
            return $this->generatePdf($html, 'Счет_ИП_' . $project->id);
        } else {
            return $this->generateDocx($html, 'Счет_ИП_' . $project->id);
        }
    }
    
    /**
     * Возвращает HTML для счета для ИП
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return string
     */
    private function getInvoiceIpHtml($project, $partner, $includeSignature, $includeStamp) {
        $now = Carbon::now();
        
        $signatureHtml = '';
        if ($includeSignature && $partner->signature_file) {
            $signatureHtml = '<img src="' . $partner->getSignatureUrl() . '" style="height: 50px; max-width: 150px;">';
        }
        
        $stampHtml = '';
        if ($includeStamp && $partner->stamp_file) {
            $stampHtml = '<img src="' . $partner->getStampUrl() . '" style="height: 100px; max-width: 100px; position: absolute; margin-left: 20px; margin-top: -60px; opacity: 0.7;">';
        }
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Счет ИП</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12pt;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .date {
                    text-align: right;
                    margin-bottom: 20px;
                }
                .footer {
                    margin-top: 30px;
                }
                .signature {
                    margin-top: 50px;
                    position: relative;
                }
            </style>
        </head>
        <body>
            <h1>СЧЕТ № ' . ($project->contract_number ?: 'б/н') . '</h1>
            <div class="date">от ' . $now->format('d.m.Y') . ' г.</div>
            
            <div>
                <p><strong>Исполнитель:</strong> ИП ' . $partner->name . '</p>
                <p><strong>ИНН:</strong> ' . ($partner->inn ?: '_________') . '</p>
                <p><strong>ОГРНИП:</strong> ' . ($partner->ogrnip ?: '_________') . '</p>
                <p><strong>Банк:</strong> ' . ($partner->bank_name ?: '_________') . '</p>
                <p><strong>Расчетный счет:</strong> ' . ($partner->bank_account ?: '_________') . '</p>
                <p><strong>Корр. счет:</strong> ' . ($partner->bank_corr_account ?: '_________') . '</p>
                <p><strong>БИК:</strong> ' . ($partner->bank_bik ?: '_________') . '</p>
            </div>
            
            <div>
                <p><strong>Заказчик:</strong> ИП ' . $project->client_name . '</p>
                <p><strong>ИНН:</strong> ' . ($project->client_inn ?: '_________') . '</p>
                <p><strong>ОГРНИП:</strong> ' . ($project->client_ogrnip ?: '_________') . '</p>
                <p><strong>Адрес:</strong> ' . ($project->address ?: 'не указан') . '</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Наименование услуги</th>
                        <th>Кол-во</th>
                        <th>Цена, руб.</th>
                        <th>Сумма, руб.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ремонтно-строительные работы по договору № ' . ($project->contract_number ?: 'б/н') . ' от ' . ($project->contract_date ? $project->contract_date->format('d.m.Y') : $now->format('d.m.Y')) . '</td>
                        <td>1</td>
                        <td style="text-align: right;">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                        <td style="text-align: right;">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="footer">
                <p>Итого: ' . number_format($project->total_amount, 2, ',', ' ') . ' руб.</p>
                <p>НДС не облагается на основании применения УСН.</p>
                <p>К оплате: ' . number_format($project->total_amount, 2, ',', ' ') . ' (' . $this->num2str($project->total_amount) . ') рублей 00 копеек.</p>
            </div>
            
            <div class="signature">
                <p>ИП ' . $partner->name . ' ___________________ </p>
                    <div class="signature">' . $signatureHtml . '</div>
                    <div class="stamp">' . $stampHtml . '</div>
            </div>
        </body>
        </html>';
        
        return $html;
    }

    /**
     * Генерирует счет для ФЛ
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  string  $format
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return \Illuminate\Http\Response
     */
    private function generateInvoiceFl($project, $partner, $format, $includeSignature, $includeStamp) {
        $html = $this->getInvoiceFlHtml($project, $partner, $includeSignature, $includeStamp);
        
        if ($format === 'pdf') {
            return $this->generatePdf($html, 'Счет_ФЛ_' . $project->id);
        } else {
            return $this->generateDocx($html, 'Счет_ФЛ_' . $project->id);
        }
    }
    
    /**
     * Возвращает HTML для счета для ФЛ
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\User  $partner
     * @param  bool  $includeSignature
     * @param  bool  $includeStamp
     * @return string
     */
    private function getInvoiceFlHtml($project, $partner, $includeSignature, $includeStamp) {
        $now = Carbon::now();
        
        $signatureHtml = '';
        if ($includeSignature && $partner->signature_file) {
            $signatureHtml = '<img src="' . $partner->getSignatureUrl() . '" style="height: 50px; max-width: 150px;">';
        }
        
        $stampHtml = '';
        if ($includeStamp && $partner->stamp_file) {
            $stampHtml = '<img src="' . $partner->getStampUrl() . '" style="height: 100px; max-width: 100px; position: absolute; margin-left: 20px; margin-top: -60px; opacity: 0.7;">';
        }
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Счет ФЛ</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12pt;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .date {
                    text-align: right;
                    margin-bottom: 20px;
                }
                .footer {
                    margin-top: 30px;
                }
                .signature {
                    margin-top: 50px;
                    position: relative;
                }
            </style>
        </head>
        <body>
            <h1>СЧЕТ № ' . ($project->contract_number ?: 'б/н') . '</h1>
            <div class="date">от ' . $now->format('d.m.Y') . ' г.</div>
            
            <div>
                <p><strong>Исполнитель:</strong> ИП ' . $partner->name . '</p>
                <p><strong>ИНН:</strong> ' . ($partner->inn ?: '_________') . '</p>
                <p><strong>ОГРНИП:</strong> ' . ($partner->ogrnip ?: '_________') . '</p>
                <p><strong>Банк:</strong> ' . ($partner->bank_name ?: '_________') . '</p>
                <p><strong>Расчетный счет:</strong> ' . ($partner->bank_account ?: '_________') . '</p>
                <p><strong>Корр. счет:</strong> ' . ($partner->bank_corr_account ?: '_________') . '</p>
                <p><strong>БИК:</strong> ' . ($partner->bank_bik ?: '_________') . '</p>
            </div>
            
            <div>
                <p><strong>Заказчик:</strong> ' . ($project->client_name ?: 'ФИО НЕ УКАЗАНЫ') . '</p>
                <p><strong>Адрес:</strong> ' . ($project->address ?: 'не указан') . '</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Наименование услуги</th>
                        <th>Кол-во</th>
                        <th>Цена, руб.</th>
                        <th>Сумма, руб.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ремонтно-строительные работы по договору № ' . ($project->contract_number ?: 'б/н') . ' от ' . ($project->contract_date ? $project->contract_date->format('d.m.Y') : $now->format('d.m.Y')) . '</td>
                        <td>1</td>
                        <td style="text-align: right;">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                        <td style="text-align: right;">' . number_format($project->total_amount, 2, ',', ' ') . '</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="footer">
                <p>Итого: ' . number_format($project->total_amount, 2, ',', ' ') . ' руб.</p>
                <p>НДС не облагается на основании применения УСН.</p>
                <p>К оплате: ' . number_format($project->total_amount, 2, ',', ' ') . ' (' . $this->num2str($project->total_amount) . ') рублей 00 копеек.</p>
            </div>
            
            <div class="signature">
                <p>ИП ' . $partner->name . ' ___________________ </p>
                    <div class="signature">' . $signatureHtml . '</div>
                    <div class="stamp">' . $stampHtml . '</div>
            </div>
        </body>
        </html>';
        
        return $html;
    }

    /**
     * Проверяет наличие и при необходимости создает шрифты с поддержкой кириллицы
     *
     * @return void
     */
    private function ensureFontsExist()
    {
        $fontsDir = storage_path('fonts/');
        
        // Создаем директорию для шрифтов, если она не существует
        if (!file_exists($fontsDir)) {
            @mkdir($fontsDir, 0755, true);
        }
        
        // Также создаем директорию для кэша шрифтов
        $fontsCacheDir = storage_path('fonts/');
        if (!file_exists($fontsCacheDir)) {
            @mkdir($fontsCacheDir, 0755, true);
        }
        
        // Проверяем, есть ли базовые шрифты с поддержкой кириллицы
        $requiredFonts = [
            'DejaVuSans.ttf',
            'DejaVuSans-Bold.ttf',
            'Arial.ttf',
            'Arial-Bold.ttf'
        ];
        
        $fontsMoved = false;
        foreach ($requiredFonts as $font) {
            $fontPath = $fontsDir . $font;
            
            // Создаем файл шрифта, если он не существует
            if (!file_exists($fontPath)) {
                // Проверяем, есть ли шрифт в директории public/fonts
                $publicFontPath = public_path('fonts/' . $font);
                if (file_exists($publicFontPath)) {
                    copy($publicFontPath, $fontPath);
                    $fontsMoved = true;
                } 
                // Альтернативные источники для шрифтов
                elseif (file_exists(public_path($font))) {
                    copy(public_path($font), $fontPath);
                    $fontsMoved = true;
                }
            }
        }
        
        // Если не удалось найти шрифты, используем системные
        if (!$fontsMoved) {
            // Для Windows сервера
            $winFontsDir = 'C:\\Windows\\Fonts\\';
            if (file_exists($winFontsDir . 'arial.ttf')) {
                copy($winFontsDir . 'arial.ttf', $fontsDir . 'Arial.ttf');
                copy($winFontsDir . 'arialbd.ttf', $fontsDir . 'Arial-Bold.ttf');
            }
        }
    }

    /**
     * Преобразует число в строковое представление прописью
     *
     * @param  float  $num
     * @return string
     */
    private function num2str($num) {
        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять')
        );
        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit = array(
            array('копейка', 'копейки', 'копеек', 1),
            array('рубль', 'рубля', 'рублей', 0),
            array('тысяча', 'тысячи', 'тысяч', 1),
            array('миллион', 'миллиона', 'миллионов', 0),
            array('миллиард', 'миллиарда', 'миллиардов', 0),
        );
        
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) {
                if (!intval($v)) continue;
                $uk = sizeof($unit) - $uk - 1;
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                $out[] = $hundred[$i1];
                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3];
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];
                if ($uk > 1) $out[] = $this->morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            }
        } else {
            $out[] = $nul;
        }
        $out[] = $this->morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]);
        
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Склоняет словоформу в зависимости от числа
     *
     * @param  int  $n
     * @param  string  $f1
     * @param  string  $f2
     * @param  string  $f5
     * @return string
     */
    private function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n == 1) return $f1;
        return $f5;
    }

    /**
     * Генерирует PDF документ из HTML
     *
     * @param  string  $html
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    private function generatePdf($html, $filename)
    {
        // Проверяем наличие шрифтов с поддержкой кириллицы
        $this->ensureFontsExist();
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVuSans');
        $options->set('isFontSubsettingEnabled', true);
        $options->set('defaultMediaType', 'screen');
        $options->set('chroot', public_path());
        
        // Настройка шрифтов с поддержкой кириллицы
        // DOMPDF ожидает строку, а не массив для fontDir
        $options->set('fontDir', storage_path('fonts/'));
        $options->set('fontCache', storage_path('fonts/'));
        
        // Добавляем специальный обработчик для русских символов
        $dompdf = new Dompdf($options);
        
        // Убеждаемся, что у нас правильная кодировка в head
        if (strpos($html, '<head>') !== false && strpos($html, 'charset') === false) {
            $html = str_replace('<head>', '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">', $html);
        } else {
            $html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $html;
        }
        
        // Добавляем стиль для поддержки кириллицы
        if (strpos($html, '</head>') !== false) {
            $fontStyle = '<style>body, table, p, h1, h2, h3, h4, h5, h6 { font-family: DejaVuSans, Arial, sans-serif !important; }</style>';
            $html = str_replace('</head>', $fontStyle . '</head>', $html);
        }
        
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();
        
        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '.pdf"');
    }
    
    /**
     * Генерирует DOCX документ из HTML
     *
     * @param  string  $html
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    private function generateDocx($html, $filename)
    {
        // Проверяем наличие шрифтов с поддержкой кириллицы
        $this->ensureFontsExist();
        
        // Формируем DOCX-совместимый HTML с явным указанием кодировки UTF-8
        $docxHtml = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
              xmlns:w="urn:schemas-microsoft-com:office:word"
              xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="ProgId" content="Word.Document">
            <meta name="Generator" content="Microsoft Word 15">
            <meta name="Originator" content="Microsoft Word 15">
            <!-- Поддержка кириллицы -->
            <xml>
                <w:WordDocument>
                    <w:View>Print</w:View>
                    <w:Zoom>100</w:Zoom>
                    <w:DoNotOptimizeForBrowser/>
                </w:WordDocument>
            </xml>
            <style>
                @font-face {font-family: "Times New Roman";}
                @font-face {font-family: "Arial";}
                body {font-family: "Arial", sans-serif;}
                table {border-collapse: collapse; width: 100%;}
                td, th {border: 1px solid black; padding: 8px;}
                .signature {margin-top: 30px;}
                /* Поддержка кириллицы */
                * {font-family: "Arial", sans-serif;}
            </style>
        </head>
        <body>' . $html . '</body></html>';
        
        // Возвращаем документ как ответ с MIME-типом для MS Word и явным указанием кодировки UTF-8
        return response($docxHtml)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '.docx"')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Expires', '0');
    }
}
