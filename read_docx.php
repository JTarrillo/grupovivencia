<?php
$zip = new ZipArchive;
if ($zip->open('INFORME BRQ 2025.docx') === TRUE) {
    file_put_contents('doc_xml.txt', $zip->getFromName('word/document.xml'));
    $zip->close();
    echo "OK";
} else {
    echo "Failed to open zip";
}
