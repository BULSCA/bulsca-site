

class ToggleContent {

    constructor(element) {
        this.header = element.querySelector('[toggle-header]')
        this.content = element.querySelector('[toggle-content]')


        this.open = true

        clazz = this

        this.header.onclick = (e) => {
            console.log("g")
            this.content.classList.toggle('collapsed')
        }
    }



}

function start() {
    document.querySelectorAll('[toggle]').forEach(e => new ToggleContent(e))
}

window.onload = start()