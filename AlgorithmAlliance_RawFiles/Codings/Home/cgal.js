const customerCarousel = document.querySelector(".customerCarousel");
const firstimg = document.querySelectorAll(".customerCarousel img")[0];
const arrowIcons = document.querySelectorAll(".Ccarousel i");

let isDragStart = false;
let prevPageX, prevScrollLeft;
let firstImgWidth = firstimg.clientWidth + 10;

arrowIcons.forEach(icon => {
  icon.addEventListener("click", () => {
    customerCarousel.scrollLeft += icon.classList.contains("ArrowLeft") ? -firstImgWidth : firstImgWidth;
  });
});

const dragStart = (e) => {
  isDragStart = true;
  prevPageX = e.pageX;
  prevScrollLeft = customerCarousel.scrollLeft;
}

const dragging = (e) => {
  if (!isDragStart) return;
  e.preventDefault();
  customerCarousel.classList.add("dragging");
  let positionDiff = e.pageX - prevPageX;
  customerCarousel.scrollLeft = prevScrollLeft - positionDiff;
}

const dragStop = () => {
  isDragStart = false;
  customerCarousel.classList.remove("dragging");
}

customerCarousel.addEventListener("mousedown", dragStart);
customerCarousel.addEventListener("mousemove", dragging);
customerCarousel.addEventListener("mouseup", dragStop);
