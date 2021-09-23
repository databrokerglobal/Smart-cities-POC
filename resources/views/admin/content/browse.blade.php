<?php 
$imageextension = ['jpg','png','jpeg','gif'];
if(file_exists(public_path('uploads/editor'))){
if ($handle = opendir(public_path('uploads/editor'))) {

    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $ext = pathinfo($entry, PATHINFO_EXTENSION);
           if(in_array(strtolower($ext),$imageextension)){
               ?><div class="files_d">
                   <img src="<?php echo url('/uploads/editor/'.$entry);  ?>" onclick="returnFileUrl('<?php echo url('/uploads/editor/'.$entry);  ?>')" />

               </div><?php
           }
        }
    }
    closedir($handle);
}
}else{
    ?><div class="no-r">No File Found.</div><?php
}

?>
<script>
        // Helper function to get parameters from the query string.
        function getUrlParam( paramName ) {
            var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
            var match = window.location.search.match( reParam );

            return ( match && match.length > 1 ) ? match[1] : null;
        }
        // Simulate user action of selecting a file to be returned to CKEditor.
        function returnFileUrl(fileUrl) {

            var funcNum = getUrlParam( 'CKEditorFuncNum' );
            window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
            window.close();
        }
    </script>

<style>

.files_d img {
    width: 100%;
    height: 100%;
}
.files_d {
    float: left;
    padding: 10px;
    border: 1px solid #ccc;
    height: 80px;
    width: 80px;
    margin: 10px;
}

</style>