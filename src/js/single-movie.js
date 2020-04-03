document.addEventListener("DOMContentLoaded", main);

function main() 
{
    let crewBtn = document.querySelector("#crewBtn");
    let castBtn = document.querySelector("#castBtn");
    
    let crew = document.querySelector("#crew");
    let cast = document.querySelector("#cast");
    
    crewBtn.addEventListener("click", changeTabs(crewBtn));
    castBtn.addEventListener("click", changeTabs(castBtn));
    
}

function changeTabs(e)
{
    let btn_val = e.value;
        
    console.log(btn_val);
        
    if(btn_val == "Crew")
    {
        crewBtn.classList.toggle("active");
        castBtn.classList.toggle("hidden");
        crew.style.display = "grid";
        cast.style.display = "none";
    }
    
    if(btn_val == "Cast")
    {
        crewBtn.classList.toggle("hidden");
        castBtn.classList.toggle("active");
        crew.style.display = "none";
        cast.style.display = "grid";
    }
}
