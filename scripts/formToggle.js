console.log("hello");
let form = document.getElementById('display');
console.log(form);
const btn = document.getElementById('togglebtn');
console.log(btn);
btn.addEventListener('click' , ()=>{
    form.classList.toggle('remove');
})