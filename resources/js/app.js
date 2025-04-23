import './bootstrap';
import 'preline';

function sidebar() {
  return {
      showMenu: false,
      xStart: null,
      init() {
          // Optional init logic
      },
      handleTouchStart(e) {
          this.xStart = e.touches[0].clientX;
      },
      handleTouchMove(e) {
          if (!this.xStart) return;
          const xEnd = e.touches[0].clientX;
          const deltaX = this.xStart - xEnd;
          if (deltaX > 60) {
              this.showMenu = false;
              this.xStart = null;
          }
      }
  }
}

window.sidebar = sidebar;