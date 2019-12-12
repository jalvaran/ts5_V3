<?php
if(file_exists("../../modelo/php_conexion.php")){
    include_once("../../modelo/php_conexion.php");
}
/* 
 * Clase que realiza los procesos de facturacion electronica
 * Julian Alvaran
 * Techno Soluciones SAS
 */

class TS_Mail extends ProcesoVenta{
    
    public function EnviarMailXPHPNativo($para,$de,$nombreRemitente, $asunto, $mensajeHTML, $Adjuntos='') {
        
        //$DatosParametrosFE=$this->DevuelveValores("facturas_electronicas_parametros", "ID", 4);
        
        //recipient
        $to = $para;

        //sender
        $from = $de;
        $fromName = $nombreRemitente;

        //email subject
        $subject = $asunto; 
        //email body content
        $htmlContent = $mensajeHTML;

        //header for sender info
        $headers = "From: $fromName"." <".$from.">";

        //boundary 
        $semi_rand = md5(time()); 
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

        //headers for attachment 
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

        //multipart boundary 
        $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

        //preparing attachment
        if($Adjuntos<>''){
            foreach($Adjuntos as $file){
                if(!empty($file) > 0){
                    if(is_file($file)){
                        $message .= "--{$mime_boundary}\n";
                        $fp =    @fopen($file,"rb");
                        $data =  @fread($fp,filesize($file));

                        @fclose($fp);
                        $data = chunk_split(base64_encode($data));
                        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
                        "Content-Description: ".basename($file)."\n" .
                        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
                        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                    }
                }
            }
        }
        $message .= "--{$mime_boundary}--";
        $returnpath = "-f" . $from;

        //send email
        $mail = @mail($to, $subject, $message, $headers, $returnpath); 

        //email sending status
        return $mail?"OK":"E1";
        
    }
    
    //Fin Clases
}