
<?php
// create directory name
$filename= $RESULT[0]->fname.' '.$RESULT[0]->lname;
$tempdir = tempnam(sys_get_temp_dir()) . $filename;
mkdir($tempdir);
?>

<?php
require_once 'HtmlToDoc.class.php'; 
// Generate MS word document with HTML
// Initialize class
$htd = new HTML_TO_DOC();

// HTML content
$htmlContent = '<table>
<tr>
<td>NAME</td>
<td>'.$RESULT[0]->fname.' '.$RESULT[0]->lname.'</td>
</tr>
<tr>
<td>Email</td>
<td>'.$RESULT[0]->email.'</td>
</tr>
</table>';


// Create docs file of html content
$htd->createDoc($htmlContent, $filename.'/page-'.$RESULT[0]->id);
$htd->createDoc($htmlContent, $filename.'/page-2'.$RESULT[0]->id);
$htd->createDoc($htmlContent, $filename.'/page-3'.$RESULT[0]->id);
$htd->createDoc($htmlContent, $filename.'/page-4'.$RESULT[0]->id);
$htd->createDoc($htmlContent, $filename.'/page-5'.$RESULT[0]->id);

// Generate MS word document with HTML
$htd->createDoc('source.html', 'files/'.time().'my-word-document-6');

// Create and download as a word file
//$htd->createDoc($htmlContent, 'files/my-word-document-word', 1);

// Convert HTML file content to MS word doc
//$htd->createDoc('source.html', 'my-word-document-ms', 1);

// Create Zip File of Folder Function 
$dir = $filename; //folder path
$archive = $RESULT[0]->fname.' '.$RESULT[0]->lname.'-download.zip';
$zip = new ZipArchive;
$zip->open($archive, ZipArchive::CREATE);
$files = scandir($dir);
unset($files[0], $files[1]);
foreach ($files as $file) {
$zip->addFile($dir.'/'.$file);
}
$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$archive);
header('Content-Length: '.filesize($archive));
readfile($archive);
unlink($archive);


?>

<?php
// Deleting all the files in the list
$folder_path = $filename;
$files = glob($folder_path.'/*');
foreach($files as $file) {
	if(is_file($file))
		unlink($file);
}

// Delete Temp Directory 
rmdir($tempdir);
?>
