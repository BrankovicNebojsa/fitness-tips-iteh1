// This JS file is primarily for modals, effect and current date

/*
=============== 
Navbar
===============
*/

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
  
  /*
  =============== 
  Date
  ===============
  */
  
  /**
   * setting current year, I don't want to be hardcoded in HTML page
   */
  const date = getElement("#date");
  const currentYear = new Date().getFullYear();
  date.textContent = currentYear;
  
  /*
  ===================================== 
  Background overlay and closing modals
  =====================================
  */
  
  /**
   *  function to set background overlay when modal needs to be shown
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
   * functio to close active modals
   */
  
  function closeModals() {
    setOverlay(false);
    setAddNewWorkoutModal(false);
    setEditProfileDataModal(false);
    setDeleteProfileModal(false);
  }
  
  /*
  ==================== 
  Add new Workout Modal
  ====================
  */
  
  /**
   * showing modal for adding workout
   */
  
  function popAddNewWorkoutModal(bool) {
    setOverlay(bool);
    setAddNewWorkoutModal(bool);
  }
  
  function setAddNewWorkoutModal(active) {
    const modal = document.querySelector("#addNewWorkoutModal");
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
  
  function popDeleteProfileModal(bool) {
    setOverlay(bool);
    setDeleteProfileModal(bool);
  }
  
  function setDeleteProfileModal(active) {
    const modal = document.querySelector("#deleteProfileModal");
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
  
  function popEditProfileDataModal(bool) {
    setOverlay(bool);
    setEditProfileDataModal(bool);
  }
  
  function setEditProfileDataModal(active) {
    const modal = document.querySelector("#editProfileDataModal");
    if (active) {
      modal.classList.add("active");
    } else {
      modal.classList.remove("active");
    }
  }
  