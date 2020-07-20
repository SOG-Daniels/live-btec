console.log(existingDocs.initialPreview);
console.log(existingDocs.initialPreviewConfig);
// This managed file uploads in the client management page
$(function () {
    $("#input-fa").fileinput({
        theme: "fas",
        uploadUrl: base_url+"upload-file/"+slug,
        uploadAsync: false,
        initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
        initialPreviewFileType: 'image', // image is the default and can be overridden in config below
        maxFileCount: 3,
        maxTotalFileCount: 5,
        overwriteInitial: false,
        allowedFileExtensions: ["docx", "pdf", "ppt", "jpg", "jpeg", "png"],
        maxFileSize: 50000,
        initialCaption: "Acceptable files are, \".docx\", \".pdf\", \".ppt\", \".jpeg\" and \".png\"",
        initialPreview: existingDocs.initialPreview,
        initialPreviewConfig: existingDocs.initialPreviewConfig       
    });
    
    // Confirmation prompt for removing an uploaded file
    $("#input-fa").on("filepredelete", function(jqXHR) {
        var abort = true;
        if (confirm("Are you sure you want to delete this file?")) {
            abort = false;
        }
        return abort; // you can also send any data/object that you can receive on `filecustomerror` event
    });
});

