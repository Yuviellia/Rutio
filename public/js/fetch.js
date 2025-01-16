const search = document.querySelector('input[placeholder="Search task"]');
const container = document.querySelector(".foreach");

search.addEventListener("keyup", function (event){
    if(event.key === "Enter"){
        event.preventDefault();
        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (todos) {
            container.innerHTML = "";
            loadToDo(todos);
        });
    }
});

function loadToDo(todos) {
    todos.forEach(todo => {
        console.log(todo);
        createToDo(todo);
    })
}

function createToDo(todo){
    const template = document.querySelector("#tmplt");
    const clone = template.content.cloneNode(true);

    const task = clone.querySelector("span");
    task.innerHTML = `${todo.task}`;

    const id = clone.querySelector("input");
    id.value = todo.id;

    container.appendChild(clone);
}









