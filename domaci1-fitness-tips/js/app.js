// Ovaj JavaScript fajl je napravljen za prozore za dodavanje novog treninga, izmenu podataka o korisniku kao i brisanje korisnika
// kao i za neke efekte na stranici i postavljanje trenutne godine u footer

// Navigacioni bar
/**
 *
 * @param {*} selector - css class
 * @returns first element which has that css class (specified in selector)
 */
const getElement = (selector) => {
    const element = document.querySelector(selector);
    if (element) return element;
    throw Error(`Please double check your class names, there is no
                 ${selector} class`);
  };
  
  const links = getElement(".nav-links");
  const navBtnDOM = getElement(".nav-btn");
  
  /**
   * statement to add class on nav-links when menu bar button is clicked
   * (this is used when site is not in full screen)
   */
  navBtnDOM.addEventListener("click", () => {
    links.classList.toggle("show-links");
  });
  
  // Datum (ovde postavljamo trenutnu godinu u element u okviru footera)
  const date = getElement("#date");
  const currentYear = new Date().getFullYear();
  date.textContent = currentYear;
  
  /*
  ===================================== 
  Background overlay and closing windows
  =====================================
  */
  
  /**
   *  function to set background overlay when window needs to be shown
   * @param {*} active - boolean to set or to remove background overlay
   */
  
  function setOverlay(active) {
    const overlay = document.querySelector("#background-overlay");
    if (active) {
      overlay.classList.add("active");
    } else {
      overlay.classList.remove("active");
    }
  }
  
  /**
   * function to close active windows
   */
  
  function closeModals() {
    setOverlay(false);
    setaddNewWorkoutWindow(false);
    seteditProfileDataWindow(false);
    setdeleteProfileWindow(false);
  }
  
  /*
  ==================== 
  Add new Workout window
  ====================
  */
  
  /**
   * showing window for adding workout
   */
  
  function popaddNewWorkoutWindow(bool) {
    setOverlay(bool);
    setaddNewWorkoutWindow(bool);
  }
  
  function setaddNewWorkoutWindow(active) {
    const modal = document.querySelector("#addNewWorkoutWindow");
    if (active) {
      modal.classList.add("active");
    } else {
      modal.classList.remove("active");
    }
  }
  
  /*
  =============== 
  Edit Profile
  ===============
  */
  
  function popeditProfileDataWindow(bool) {
    setOverlay(bool);
    seteditProfileDataWindow(bool);
  }
  
  function seteditProfileDataWindow(active) {
    const modal = document.querySelector("#editProfileDataWindow");
    if (active) {
      modal.classList.add("active");
    } else {
      modal.classList.remove("active");
    }
  }

  /*
  =============== 
  Delete Profile
  ===============
  */
  
  function popdeleteProfileWindow(bool) {
    setOverlay(bool);
    setdeleteProfileWindow(bool);
  }
  
  function setdeleteProfileWindow(active) {
    const modal = document.querySelector("#deleteProfileWindow");
    if (active) {
      modal.classList.add("active");
    } else {
      modal.classList.remove("active");
    }
  }
  