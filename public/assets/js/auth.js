// auth.js

// Hide toastr options inside a function or object
function configureToastr() {
  toastr.options = {
      "closeButton": true,
      "progressBar": true,
  };
}

// Call the function only when a toast is needed
if (typeof toastr !== 'undefined') {
  configureToastr();
  // console.log('Toastr is ready');
}
