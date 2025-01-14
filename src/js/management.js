// ACCIONES
const actions = document.querySelectorAll('.sticky-menu button, .profile button:not(.close-profile)')
const sections = document.querySelectorAll('main section');

actions.forEach((button) => {
  button.addEventListener('click', () => {
    sections.forEach((section) => {section.classList.add('hidden')});
    actions.forEach((button) => {button.style.textDecoration = "none";});
    switch (button.id) {
      case 'accept-teachers':
        const acceptTeachers = document.querySelector('.'+button.id);
        if (window.getComputedStyle(acceptTeachers).getPropertyValue('display') === "none") {
          acceptTeachers.classList.remove('hidden');
          button.style.textDecoration = "underline";
        } else if (window.getComputedStyle(document.querySelector('.'+button.id)).getPropertyValue('display') === "flex") {
          acceptTeachers.classList.add('hidden');
          button.style.textDecoration = "none";
        }
        break;

      case 'accept-languages':
        const acceptLanguages = document.querySelector('.'+button.id);
        if (window.getComputedStyle(acceptLanguages).getPropertyValue('display') === "none") {
          acceptLanguages.classList.remove('hidden');
          button.style.textDecoration = "underline";
        } else if (window.getComputedStyle(document.querySelector('.'+button.id)).getPropertyValue('display') === "flex") {
          acceptLanguages.classList.add('hidden');
          button.style.textDecoration = "none";
        }
        break;

      case 'accept-books':
        const acceptBooks = document.querySelector('.'+button.id);
        if (window.getComputedStyle(acceptBooks).getPropertyValue('display') === "none") {
          acceptBooks.classList.remove('hidden');
          button.style.textDecoration = "underline";
        } else if (window.getComputedStyle(acceptBooks).getPropertyValue('display') === "grid") {
          acceptBooks.classList.add('hidden');
          button.style.textDecoration = "none";
        }
        break;

      case 'accept-comments':
        const acceptComments = document.querySelector('.'+button.id);
        const acceptAnswer = document.querySelector('.accept-answers');
        if (window.getComputedStyle(acceptComments).getPropertyValue('display') === "none") {
          acceptComments.classList.remove('hidden');
          acceptAnswer.classList.remove('hidden');
          button.style.textDecoration = "underline";
        } else if (window.getComputedStyle(acceptComments).getPropertyValue('display') === "flex") {
          acceptComments.classList.add('hidden');
          acceptAnswer.classList.add('hidden');
          button.style.textDecoration = "none";
        }
        break;

      case 'admins':
        const admins = document.querySelector('.'+button.id);
        if (window.getComputedStyle(admins).getPropertyValue('display') === "none") {
          admins.classList.remove('hidden');
          button.style.textDecoration = "underline";
        } else if (window.getComputedStyle(admins).getPropertyValue('display') === "flex") {
          admins.classList.add('hidden');
          button.style.textDecoration = "none";
        }
        break;
        
      case 'accept-students':
      const acceptStudents = document.querySelector('.'+button.id);
      if (window.getComputedStyle(acceptStudents).getPropertyValue('display') === "none") {
        acceptStudents.classList.remove('hidden');
        button.style.textDecoration = "underline";
      } else if (window.getComputedStyle(document.querySelector('.'+button.id)).getPropertyValue('display') === "flex") {
        acceptStudents.classList.add('hidden');
        button.style.textDecoration = "none";
      }
      break;
      case 'current-students':
      const currentStudents = document.querySelector('.'+button.id);
      if (window.getComputedStyle(currentStudents).getPropertyValue('display') === "none") {
        currentStudents.classList.remove('hidden');
        button.style.textDecoration = "underline";
      } else if (window.getComputedStyle(document.querySelector('.'+button.id)).getPropertyValue('display') === "flex") {
        currentStudents.classList.add('hidden');
        button.style.textDecoration = "none";
      }
      break;
    }
  });
});

// LIBROS
const bookContainer = document.querySelectorAll('.book-container');

bookContainer.forEach((book) => {
  book.addEventListener('mouseover', () => {
    book.style.zIndex = 2;
    book.style.boxShadow = ".5rem .5rem 1rem rgba(0, 0, 0, 0.7)";
    book.firstElementChild.style.transform = "scale(1.5)";
    book.lastElementChild.style.transform = "translateY(0)";
  });

  book.addEventListener('mouseout', () => {
    book.style.zIndex = 1;
    book.style.boxShadow = "none";
    book.firstElementChild.style.transform = "scale(1)";
    book.lastElementChild.style.transform = "translateY(-100%)";
  });
});

// FORMULARIO REGISTRO ADMINISTRADOR
const form = document.getElementById('singupForm');
const inputs = document.querySelectorAll('#singupForm input');
const errors = document.querySelectorAll('.php-error');

setTimeout(() => {
  errors.forEach((error) => {error.classList.add('hidden')});
}, 5000);

const regexs = {
  nickname: /^[a-zA-Z0-9\_\-]{4,20}$/,
  name: /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/,
  surnames: /^([A-ZÁÉÍÓÚ a-zñáéíóú]{1,})+$/,
  email: /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/,
}

// Campos del formulario
const campos = {
  nickname: false,
  email: false,
  name: false,
  surnames: false,
}

const form_validation= (e)=>{
    errors.forEach((error) => {error.classList.add('hidden')});
    switch (e.target.name) {

      case "nickname":
        if (regexs.nickname.test(e.target.value)) {
            document.getElementById('nickname').classList.remove('input_error');
            document.getElementById('nickname-error').classList.add('hidden');
            campos.nickname = true;
        } else if (e.target.value === '') {
            document.getElementById('nickname').classList.remove('input_error');
            document.getElementById('nickname-error').classList.add('hidden');
        } else {
            document.getElementById('nickname').classList.add('input_error');
            document.getElementById('nickname-error').classList.remove('hidden');
        }
        break;  

        case "email":
            if (regexs.email.test(e.target.value)){
                document.getElementById('email').classList.remove('input_error');
                document.getElementById('email-error').classList.add('hidden');
                campos.email = true;
            } else if (e.target.value === '') {
                document.getElementById('email').classList.remove('input_error');
                document.getElementById('email-error').classList.add('hidden');
            } else {
                document.getElementById('email').classList.add('input_error');
                document.getElementById('email-error').classList.remove('hidden');
            }
            break; 

        case "name":
          if (regexs.name.test(e.target.value)) {
              document.getElementById('name').classList.remove('input_error');
              document.getElementById('name-error').classList.add('hidden');
              campos.name = true;
          } else if (e.target.value === '') {
              document.getElementById('name').classList.remove('input_error');
              document.getElementById('name-error').classList.add('hidden');
          } else {
              document.getElementById('name').classList.add('input_error');
              document.getElementById('name-error').classList.remove('hidden');
          }
          break;
  
          case "surnames":
              if (regexs.surnames.test(e.target.value)) {
                  document.getElementById('surnames').classList.remove('input_error');
                  document.getElementById('surnames-error').classList.add('hidden');
                  campos.surnames = true;
              } else if (e.target.value === '') {
                  document.getElementById('surnames').classList.remove('input_error');
                  document.getElementById('surnames-error').classList.add('hidden');
              } else {
                  document.getElementById('surnames').classList.add('input_error');
                  document.getElementById('surnames-error').classList.remove('hidden');
              }
              break;
    }
}

// PERFIL
const profileButton = document.querySelector('#profile');
const profile = document.querySelector('.profile');
const profileLinks = document.querySelectorAll('.profile a, .profile span');
const closeProfile = document.querySelector('.close-profile');

profileButton.addEventListener('mouseover', () => {
  profileButton.style.transform = 'scale(1.1)';
  profileButton.style.textShadow = ".3rem .3rem .3rem #00000050";
  profileButton.style.cursor = "pointer";
});

profileButton.addEventListener('mouseleave', () => {
  profileButton.style.transform = 'scale(1)';
  profileButton.style.textShadow = "none";
});

profileButton.addEventListener('click', () => {
  profile.style.display = "flex";
  setTimeout(() => {
    profile.style.transform = "translateX(0)";
  }, 10);
});

if (screen.width > 1280) {
  profile.addEventListener('mouseleave', () => {
    profile.style.transform = "translateX(100%)";
    setTimeout(() => {
      profile.style.display = "none";
    }, 500);
  });
} else {
  closeProfile.addEventListener('click', () => {
    profile.style.transform = "translateX(100%)";
    setTimeout(() => {
      profile.style.display = "none";
    }, 500);
  });
}

profileLinks.forEach((link) => {
  link.addEventListener('mouseover', () => {
    link.style.color = "black";
    link.style.transform = "translateX(1rem)";
  });

  link.addEventListener('mouseout', () => {
    link.style.color = "gray";
    link.style.transform = "translateX(0)";
  });
});

// ADMINISTRADORES
inputs.forEach((input) => {
  input.addEventListener('keyup', form_validation);
  input.addEventListener('blur', form_validation);
});

form.addEventListener('submit', (e) => {  
  if(!campos.nickname || !campos.name || !campos.surnames || !campos.email) {
      e.preventDefault();
      document.getElementById('form-error').classList.remove('hidden');
      setTimeout(() => {
    document.getElementById('form-error').classList.add('hidden');
  }, 3500);
  }
});

inputs.forEach((input) => {
  input.addEventListener('keyup', form_validation);
  input.addEventListener('blur', form_validation);
});

form.addEventListener('submit', (e) => {  
  if(!campos.nickname || !campos.name || !campos.surnames || !campos.email) {
      e.preventDefault();
      document.getElementById('form-error').classList.remove('hidden');
      setTimeout(() => {
    document.getElementById('form-error').classList.add('hidden');
  }, 3500);
  }
});