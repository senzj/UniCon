// Code for showing alert message
// $(document).ready(function() {
//   setTimeout(function() {
//       $(".alert").fadeOut("slow", function() {
//           $(this).remove();
//       });
//   }, 8000); // Time in milliseconds (3000ms = 3 seconds)
// });

const body = document.querySelector('body');
const buttons = document.querySelectorAll('button');

buttons.forEach((button) => {
  button.addEventListener('click', () => {
    if(button.id === "success"){
      console.log('success');
    } else if(button.id === "danger"){
      console.log('danger');
    } else if(button.id === "btn-info"){
      console.log('info');
    } else if(button.id === "btn-warning"){
      console.log('warning');
    } else {
      console.log('none selected');
    }
  });
});

