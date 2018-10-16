$('#add-image').click(() => {
  //getting future fields' number
  const index = +$('#widgets-counter').val();

  //getting entry's prototype
  const tmpl = $('#annonce_images').data('prototype').replace(/__name__/g, index);

  //injecting tmpl in div
  $('#annonce_images').append(tmpl);

  $('#widgets-counter').val(index + 1);

  handleDeleteButtons();

});

function handleDeleteButtons() {
  $('button[data-action="delete"]').click(function(){
    const target = this.dataset.target;
    $(target).remove();
  });
}

function updateCounter() {
  const count = +$('#annonce_images div.form-group').length;

  $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();