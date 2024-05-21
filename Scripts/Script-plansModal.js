const planHeaderButton = document.querySelector('.planHeaderButton')
const sellModalContainer = document.querySelector('.sellModalContainer');
const overlaySellModal = document.querySelector('.overlaySellModal');
const closePlansButto = document.querySelector('.closePlansButto');



 const closePlans = (e) =>{

    sellModalContainer.classList.add('hidden');
    overlaySellModal.classList.add('hidden');
 }
planHeaderButton.addEventListener('click', (e) => {
    e.preventDefault();
    sellModalContainer.classList.remove('hidden');
    overlaySellModal.classList.remove('hidden');
});
overlaySellModal.addEventListener('click', closePlans);
closePlansButto.addEventListener('click', closePlans);