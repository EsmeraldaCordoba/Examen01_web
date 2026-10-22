<?php
    // devuelve el tipo de documento a partir de la extension del archivo
    function tipoDocumento($extension) {
        $extension = strtolower($extension);

        switch ($extension) {
            case 'doc':
            case 'docx':
                return 'Word';
            case 'xls':
            case 'xlsx':
            case 'csv':
                return 'Excel';
            case 'ppt':
            case 'pptx':
                return 'PowerPoint';
            case 'pdf':
                return 'PDF';
            case 'txt':
                return 'Texto';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'bmp':
            case 'webp':
            case 'svg':
                return 'Imagen';
            case 'zip':
            case 'rar':
            case '7z':
                return 'Comprimido';
            case 'mp3':
            case 'wav':
                return 'Audio';
            case 'mp4':
            case 'avi':
            case 'mkv':
                return 'Video';
            default:
                return 'Otro (' . $extension . ')';
        }
    }

    // si el archivo se puede ver en pantalla (pdf e imagenes) devuelve su tipo mime,
    // si no se puede ver devuelve vacio y entonces se descarga
    function mimePantalla($extension) {
        $extension = strtolower($extension);

        switch ($extension) {
            case 'pdf':
                return 'application/pdf';
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            case 'bmp':
                return 'image/bmp';
            case 'webp':
                return 'image/webp';
            default:
                return '';
        }
    }