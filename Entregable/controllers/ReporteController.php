<?php
require_once __DIR__ . '/../lib/tcpdf/tcpdf.php';

class ReporteController {
    private $cliente;
    private $proyecto;

    public function __construct() {
        $this->verificarSesion();
        $this->cliente = new Cliente();
        $this->proyecto = new Proyecto();
    }

    private function verificarSesion() {
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
    }

    public function reporteClientes() {
        $clientes = $this->cliente->obtenerTodos();
        
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('TecnoSoluciones S.A.');
        $pdf->SetTitle('Reporte de Clientes');
        $pdf->SetSubject('Listado de Clientes');
        
        $pdf->setHeaderData('', 0, 'TecnoSoluciones S.A.', 'Reporte de Clientes - ' . date('d/m/Y'));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        $pdf->AddPage();
        
        $html = '<h1>Reporte de Clientes</h1>';
        $html .= '<table border="1" cellpadding="5">';
        $html .= '<tr style="background-color:#f0f0f0;"><th>ID</th><th>Nombre</th><th>Email</th><th>Empresa</th><th>Teléfono</th></tr>';
        
        foreach ($clientes as $cliente) {
            $html .= '<tr>';
            $html .= '<td>' . $cliente['id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($cliente['nombre']) . '</td>';
            $html .= '<td>' . htmlspecialchars($cliente['email']) . '</td>';
            $html .= '<td>' . htmlspecialchars($cliente['empresa']) . '</td>';
            $html .= '<td>' . htmlspecialchars($cliente['telefono']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('reporte_clientes.pdf', 'I');
    }

    public function reporteProyectos() {
        $proyectos = $this->proyecto->obtenerTodos();
        
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('TecnoSoluciones S.A.');
        $pdf->SetTitle('Reporte de Proyectos');
        $pdf->SetSubject('Listado de Proyectos');
        
        $pdf->setHeaderData('', 0, 'TecnoSoluciones S.A.', 'Reporte de Proyectos - ' . date('d/m/Y'));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        $pdf->AddPage();
        
        $html = '<h1>Reporte de Proyectos</h1>';
        $html .= '<table border="1" cellpadding="5">';
        $html .= '<tr style="background-color:#f0f0f0;"><th>ID</th><th>Proyecto</th><th>Cliente</th><th>Estado</th><th>Presupuesto</th></tr>';
        
        foreach ($proyectos as $proyecto) {
            $html .= '<tr>';
            $html .= '<td>' . $proyecto['id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($proyecto['nombre']) . '</td>';
            $html .= '<td>' . htmlspecialchars($proyecto['cliente_nombre']) . '</td>';
            $html .= '<td>' . htmlspecialchars($proyecto['estado']) . '</td>';
            $html .= '<td>$' . number_format($proyecto['presupuesto'], 2) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('reporte_proyectos.pdf', 'I');
    }
}
?>