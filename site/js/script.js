let sort_by_selector = document.querySelector('#sort_by');

function changeSortBuy() {
  switch (Number(sort_by_selector.value)) {
    case 0:
      window.location.href = "/semester_exam_4/site/buy.php?sort_by=0";
      break;
    case 1:
      window.location.href = "/semester_exam_4/site/buy.php?sort_by=1";
      break;
    case 2:
      window.location.href = "/semester_exam_4/site/buy.php?sort_by=2";
      break;
    case 3:
      window.location.href = "/semester_exam_4/site/buy.php?sort_by=3";
      break;
    case 4:
      window.location.href = "/semester_exam_4/site/buy.php?sort_by=4";
      break;
    case 5:
      window.location.href = "/semester_exam_4/site/buy.php?sort_by=5";
      break;
    case 6:
      window.location.href = "/semester_exam_4/site/buy.php?sort_by=6";
      break;
  }
}

function changeSortInventory() {
  switch (Number(sort_by_selector.value)) {
    case 0:
      window.location.href = "/semester_exam_4/site/inventory.php?sort_by=0";
      break;
    case 1:
      window.location.href = "/semester_exam_4/site/inventory.php?sort_by=1";
      break;
    case 2:
      window.location.href = "/semester_exam_4/site/inventory.php?sort_by=2";
      break;
    case 3:
      window.location.href = "/semester_exam_4/site/inventory.php?sort_by=3";
      break;
    case 4:
      window.location.href = "/semester_exam_4/site/inventory.php?sort_by=4";
      break;
    case 5:
      window.location.href = "/semester_exam_4/site/inventory.php?sort_by=5";
      break;
    case 6:
      window.location.href = "/semester_exam_4/site/inventory.php?sort_by=6";
      break;
  }
}