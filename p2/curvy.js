addEvent(window, 'load', initCorners);

function initCorners() {
    var settings = {
      tl: { radius: 16 },
      tr: { radius: 16 },
      bl: { radius: 16 },
      br: { radius: 16 },
      antiAlias: false
    }
    curvyCorners(settings, ".roudnd");
 
  }
