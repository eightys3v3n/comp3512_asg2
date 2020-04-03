document.addEventListener("DOMContentLoaded", main);

function main() 
{
    let crewBtn = document.querySelector("#crewBtn");
    let castBtn = document.querySelector("#castBtn");
    
    let crew = document.querySelector("#crew");
    let cast = document.querySelector("#cast");
    
    crewBtn.addEventListener("click", changeTabs);
    castBtn.addEventListener("click", changeTabs);
    
}

function changeTabs(e)
{
    let btn_val = e.target.value;
        
    console.log(btn_val);
        
    if(btn_val == "Crew")
    {
        crewBtn.classList.add("active");
        castBtn.classList.remove("active");
        crew.style.display = "grid";
        cast.style.display = "none";
    }
    else if(btn_val == "Cast")
    {
        castBtn.classList.add("active");
        crewBtn.classList.remove("active");
        crew.style.display = "none";
        cast.style.display = "grid";
    }
}
