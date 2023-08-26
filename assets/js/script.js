const taskInput = document.getElementById("taskInput");
const addButton = document.getElementById("addButton");
const taskList = document.getElementById("taskList");

addButton.addEventListener("click", () => {
    const taskText = taskInput.value;
    if (taskText.trim() !== "") {
        const li = document.createElement("li");
        const span = document.createElement("span"); // Criar um novo elemento span para cada tarefa
        span.textContent = taskText;
        
        const finalizado = document.createElement("button");
        finalizado.className = "finalizado";
        finalizado.textContent = "Finalizado";

        li.appendChild(span);
        li.appendChild(finalizado);
        
        taskList.appendChild(li);
        taskInput.value = "";

        finalizado.addEventListener("click", () => {
            span.style.cssText = "color: red; text-decoration: line-through;";
        });
    }
});
