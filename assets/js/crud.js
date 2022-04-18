let contactContainer = document.getElementById("contactContainer");
let contactForm = document.getElementById("contactForm");
let deleteContactBtn = document.getElementsByClassName("fa-trash");
let contactModal = document.getElementById('contactModal');
let closeModal = document.getElementById('closeModal');
let overlay = document.getElementById('overlay');
let newContact = document.getElementById('addContact');



// ===================== events ====================
overlay.addEventListener('click', hideForm);
closeModal.addEventListener('click', hideForm);
newContact.addEventListener('click', showForm);
document.addEventListener("DOMContentLoaded", getContact);
contactContainer.addEventListener("click", function (e) {
  let { role} = e.target.dataset;
  if (role === "delete") {
    deleteContact(e);
  } else if(role === "update") {
    let { id } = e.target.parentElement.parentElement.dataset;
    let idInput = document.createElement("input");
    idInput.setAttribute("type", "hidden");
    idInput.setAttribute("name", "id");
    idInput.setAttribute("value", id);
    idInput.setAttribute("id", "idInput");
    contactForm.appendChild(idInput);
    showForm(e);
    getContactById(id);
  }
});

contactForm.addEventListener("submit", manageContact);

// ======================== get contact function ====================
function getContact() {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "./functions/getContacts.php");
  xhr.onload = function () {
    // check status of response
    if (this.status === 200) {
      let contacts = JSON.parse(this.responseText);
      // if there is no contact
      if (!contacts) {
        contactContainer.innerHTML = `
              <div class="w-full p-4 flex flex-col items-center select-none">
                <h1 class="text-gray-600 text-4xl">No contacts yet</h1>
                <p class="text-gray-600">Add your contacts by clicking the + button</p>
                <img draggable="false" src="./assets/images/nocontact.gif" alt="empty contact" class="w-64">
              </div>
          `;
        return;
      }
      // if there is contacts
      contactContainer.innerHTML = "";
      contacts.forEach(function (contact) {
        let contactDiv = `
            <div class="flex flex-col md:flex-row w-full pb-5" data-id="${contact["id"]}">
              <div class="p-5 flex w-full items-start gap-3 shadow-lg">
                <div class="w-14">
                  <img draggable="false" src="./assets/images/${contact["image"]}" alt="profile image" class="w-12 h-12 rounded-full">
                </div>
                <div class="space-y-2 flex-1">
                  <h1 class="font-semibold text-xl">${contact["fname"]} ${contact["lname"]}</h1>
                  <p class="text-gray-600">
                    <i class="fa-solid fa-envelope text-gray-600"></i> ${contact["email"]}
                  </p>
                  <p class="text-gray-600">
                    <i class="fa-solid fa-phone"></i> ${contact["phone"]}
                  </p>
                  <p class="text-gray-600">
                    <i class="fa-solid fa-map-marker-alt"></i> ${contact["address"]}
                  </p>
                </div>
              </div>
              <!-- favourite, edit and delete buttons -->
              <div class="flex md:flex-col">
                <button class="flex-1 h-14 md:h-auto bg-purple-600 text-white flex justify-center items-center">
                  <i class="fa-solid fa-star"></i>
                </button>
                <button data-role="update" class="flex-1 w-12 bg-purple-600 text-white flex justify-center items-center">
                  <i class="pointer-events-none fa-solid fa-edit"></i>
                </button>
                <button data-role="delete" class="flex-1 w-12 bg-purple-600 text-white flex justify-center items-center">
                  <i class="pointer-events-none fa-solid fa-trash"></i>
                </button>
              </div>
            </div>
          `;
        contactContainer.innerHTML += contactDiv;
      });
    }
    // console.log(this.responseText);
  };
  xhr.send();
}

// ====================== deleteContact function ======================
function deleteContact(e) {
  let { id } = e.target.parentElement.parentElement.dataset;
  let xhr = new XMLHttpRequest();
  xhr.open('GET', `./functions/deleteContact.php?id=${id}`);
  xhr.onload = function () {
    if (this.status === 200) {
      getContact();
    }
  };
  xhr.send();
} 

// ====================== updateContact function ======================
function updateContact(e) {
  let { id } = e.target.parentElement.parentElement.dataset;
  let xhr = new XMLHttpRequest();
  xhr.open('GET', `./functions/updateContact.php?id=${id}`);
  xhr.onload = function () {
    if (this.status === 200) {
      hideForm();
    }
  };
  xhr.send();
}


// ==================== addContact function ====================
function manageContact(e) {
  e.preventDefault();
  let fname = document.getElementById("fname").value;
  let lname = document.getElementById("lname").value;
  let email = document.getElementById("email").value;
  let phone = document.getElementById("phone").value;
  let address = document.getElementById("address").value;
  let mode = document.getElementById("mode").value
  let data = new FormData();
  data.append("fname", fname);
  data.append("lname", lname);
  data.append("email", email);
  data.append("phone", phone);
  data.append("address", address);
  data.append("mode", mode);
  if(mode == "update") {
    let id = document.getElementById("idInput").value;
    data.append("id", id);
  }

  let xhr = new XMLHttpRequest(); 
  xhr.open("POST", "./functions/manageContact.php");
  xhr.onload = function () {
    if (this.status === 200) {
      if(this.responseText === "success") {
        contactForm.reset();
        getContact();
        hideForm();
      }
      // TODO: handle error case
    }
  };
  xhr.send(data);
}

// ====================== hideForm / showForm function ======================
function hideForm() {
  contactModal.classList.add("hidden");
  overlay.classList.add("hidden");
}
function showForm(e) {
  contactModal.classList.remove("hidden");
  overlay.classList.remove("hidden");
  if(this == newContact) {
    document.querySelector('[type="hidden"]').value = "add";
  } else {
    let { id } = e.target.parentElement.parentElement.dataset;
    document.querySelector('[type="hidden"]').value = "update";
  }
}

// ===================== getContactById function =====================
function getContactById(id) {
  let xhr = new XMLHttpRequest();
  xhr.open('GET', `./functions/getContactById.php?id=${id}`);
  xhr.onload = function () {
    if (this.status === 200) {
      let contact = JSON.parse(this.responseText);
      document.getElementById("fname").value = contact["fname"];
      document.getElementById("lname").value = contact["lname"];
      document.getElementById("email").value = contact["email"];
      document.getElementById("phone").value = contact["phone"];
      document.getElementById("address").value = contact["address"];
    }
  };  
  xhr.send();
}