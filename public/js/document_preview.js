function previewDocument(url) {
    Swal.fire({
        title: 'PDF Preview',
        html: `<iframe src="${url}" width="100%" height="400px" onerror="downloadDocument('${url}')"></iframe>`,
        width: '80%',
        showCloseButton: true,
        showConfirmButton: false
    });
}

function downloadDocument(url) {
    window.location.href = url;
}
