function setErrorsBS() {
   const NO_VALID = 'is-invalid';
   var errors = document.getElementsByClassName('errors');
   if (errors.length) {
       const issues = errors[0].children[0].children;
       for (let index = 0; index < issues.length; index++) {
            const msg = issues[index].textContent.split("|");
            const element = document.getElementById(msg[1]);
            element.classList.add (NO_VALID);
            issues[index].textContent = msg[0];
       }
   }
}
setErrorsBS();
