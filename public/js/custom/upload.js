
/*https://codepen.io/johnnybegood21/pen/eQQvPE*/
$(() => {
    const showFileInfo = (file) => {
        $('#info').text(`Nombre del archivo: ${file.name}\nMime Type: ${file.type}`);
        $("#btn-import").fadeIn();

    } 
    $('#test').on('change', (e) => {
        e.preventDefault();
        const file = $('#test')[0].files[0];
        console.log({file});
        showFileInfo(file);
      })
  });
  