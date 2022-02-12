function setErrorsBS() {
   var errors = document.getElementsByClassName('errors');
   if (errors) {
       const issues = errors[0].children[0].children;
       for (let index = 0; index < issues.length; index++) {
            const msg = issues[index].textContent.split("|");
            const element = document.getElementById(msg[1]);
            element.className = element.className + ' is-invalid';
            issues[index].textContent = msg[0];
       }
   }
}
setErrorsBS();
