// LIBROS
const bookContainer = document.querySelectorAll('.book-container');

bookContainer.forEach((book) => {
  book.addEventListener('mouseover', () => {
    book.style.transform = "scale(1.2)";
    book.style.zIndex = 2;
    book.style.boxShadow = ".5rem .5rem 1rem rgba(0, 0, 0, 0.7)";
    book.firstElementChild.style.transform = "scale(1.5)";
    book.lastElementChild.style.transform = "translateY(0)";
  });

  book.addEventListener('mouseout', () => {
    book.style.transform = "scale(1)";
    book.style.zIndex = 1;
    book.style.boxShadow = "none";
    book.firstElementChild.style.transform = "scale(1)";
    book.lastElementChild.style.transform = "translateY(-100%)";
  });
});
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
