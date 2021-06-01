/*
    JS ES 6+
*/

// Onload document
let inputEmail = tagId('row_email')
let inputName = tagId('row_name')
let inputPassword = tagId('row_password')
let inputNewPassword = tagId('row_new_password')
let inputNewPasswordRepeated = tagId('row_new_password_repeated')
let inputImage = tagId('imageFile')

inputPassword.focus()

// Handle errors on UI
saveRegisterAlert = (element = null, message) => {
    tagId('save-action-status').innerHTML = message
    if (element != null) {
        element.previousElementSibling.classList.add('text-danger')
        element.focus()
    }
}
tagAll('.form-control').forEach((element) => {
    element.addEventListener('blur', () => {
        element.previousElementSibling.classList.remove('text-danger')
        tagId('save-action-status').innerHTML = ''
    }) 
})

// Register
updateRegisterProcess = (state = false) => {    
    if(state === true) {        
        tagId('action_btn_save').innerHTML = `<i class="fa fa-spin fa-spinner"></i> wait...`
        tagId('action_btn_save').disabled = true
        tagId('action_btn_cancel').disabled = true
        tagId('action_btn_delete').disabled = true
    } else {
        tagId('action_btn_save').innerHTML = `<i class="fa fa-check fa-fw"></i> Update`
        tagId('action_btn_save').disabled = false
        tagId('action_btn_cancel').disabled = false
        tagId('action_btn_delete').disabled = false
    }
}

updateRegister = (targetID) => {
    let form = Object.create(null)
    let data = Object.create(null)    
    let resp = Object.create(null)

    data.id = targetID
    data.email = inputEmail.value
    data.name = inputName.value
    data.password = inputPassword.value
    data.new_password = inputNewPassword.value
    data.new_password_repeated = inputNewPasswordRepeated.value
    
    if ( data.id > 0 || data.name != "" ) {
        updateRegisterProcess (true)

        // Ajax send
        form.url  = AdminPath + '/form/' + Layout
        form.function = Layout
        form.action = 'updateRegister'
        form.json = data
        if (inputImage.files.length) {
            form.files = inputImage.files
        } else {
            if (imageDelete && imageDelete.value == 1) data.imageDelete = imageDelete.value
        }

        formPost(form).then(json => {
            if (json.status == 'error') {
                alert('some error has occured - watch console log')
                console.log(json.message)
            } else if (json.status == 'field') {
                console.log(json.message)
                if (json.message.email) { saveRegisterAlert(inputEmail, json.message.email) }
                else if (json.message.name) { saveRegisterAlert(inputName, json.message.name) }
                else if (json.message.password) { saveRegisterAlert(inputPassword, json.message.password) }
                else if (json.message.new_password) { saveRegisterAlert(inputNewPassword, json.message.new_password) }
                else if (json.message.new_password_repeated) { saveRegisterAlert(inputNewPasswordRepeated, json.message.new_password_repeated) }
                else if (json.message.image) {
                    Object.entries(json.message.image).forEach( ([key, value]) => {
                        if (key == 'size') unit = ` bytes.`; else unit = ` px.`
                        text = `image: ${value}` + unit
                    });
                    saveRegisterAlert(null, text)
                }
                else {
                    message = 'some filed has an error value - watch console log'
                    alert(message)
                    console.log(json.message)
                }
            } else {

                resp.close  = false
                resp.title  = `<i class="fa fa-file-text-o fa-wd"></i> Update user's register`
                resp.body   = `The register's information has been updated successfully`
                resp.footer = `<a href="${AdminPath}/users" class="btn btn-default pull-left">Back to list</a>
                               <a href="" class="btn btn-success">Close dialogue</a>`
                jqueryModal({show: true, data: resp})
                console.log(json)
            }
            updateRegisterProcess ()
        }).catch( console.error() )
    }
}
tagId('action_btn_save').addEventListener('click', function (e) {
    id = this.dataset.target
    updateRegister(id)
})

// delete register
deleteRegister = function(e) {
    deleteRegister = tagId('action_btn_delete')
    id = deleteRegister.dataset.target
    
    let form = Object.create(null)
    let data = Object.create(null)

    data.id = id

    if ( data.id > 0 ) {

        document.querySelector('.modal-header').innerHTML = `<i class="fa fa-spinner fa-spin"></i> Deleting register`
        document.querySelector('.modal-body').innerHTML = `Please, wait until register is erased`
        document.querySelector('.modal-footer').innerHTML = `<button type="button" class="btn btn-danger"><i class="fa fa-spinner fa-spin"></i>  wait...</button>`

        form.url = AdminPath + '/json/' + Layout
        form.function = Layout
        form.action = 'deleteRegister'
        form.json = data
        jsonPost(form).then(json => {
            if (json.status == 'error') {
                alert('something went wrong - watch console log');
                console.log(json.message)
            } else {

                document.querySelector('.modal-header').innerHTML = `<i class="fa fa-trash fa-fw"></i> Register deleted`
                document.querySelector('.modal-body').innerHTML   = `Register and its dependencies have been deleted`
                document.querySelector('.modal-footer').innerHTML = `<a href="${AdminPath}/users" class="btn btn-success"><i class="fa fa-check fa-fw"></i>  Back to Users</a>`

                console.log(json.message)
            }
        }).catch( console.error() )        
    }
    
}

deleteRegisterDialogue = (id) => {
    let resp    = Object.create(null)
    resp.close  = false
    resp.title  = `<i class="fa fa-exclamation-triangle fa-wd"></i> Delete register`
    resp.body   = `Are you sure to delete <b>${inputName.value}</b> register?`
    resp.footer = `<button type="button" class="btn btn-default pull-left" data-dismiss="modal">No, close</button>
                   <button type="button" class="btn btn-danger" id="deleteRegisterDialogueBtn" data-target="${id}">Yes, delete</button>`
    jqueryModal({show: true, data: resp})
}

tagId('action_btn_delete').addEventListener('click', function (e) {
    id = this.dataset.target
    deleteRegisterDialogue(id)
})

/*
    Image
*/
let imageSelect = tagId('imageSelect'),
    imageElem   = tagId('imageFile'),
    imageList   = tagId('imageList'),
    imageSet    = tagId('imageSet'),
    imageNull   = tagId('imageNull'),
    imageDelete = tagId('imageDelete')

imageSelect.addEventListener("click", (e) => {
    if (imageElem) imageElem.click()
    e.preventDefault() // prevent navigation to "#"
}, false)

imageElem.addEventListener("change", handleFiles, false)

function handleFiles() {
    // for multiple files upload add attribute "multiple" to input tag and remove "this.files.length" condition 
    if (!this.files.length|| this.files.length != 1) {        
        imageList.innerHTML = `<p>No files selected!</p>`
    } else {        
        sizeLimit = 2097152 // 2MB
        imageOverLimit = 0
        for (let i = 0; i < this.files.length; i++) {
            if( this.files[i].size > sizeLimit ) imageOverLimit = parseInt(imageOverLimit) + 1
        }        
        if (imageOverLimit > 0) {
            imageList.innerHTML = "<p>File size is bigger than 2MB - No file selected!</p>"
        } else {
            imageList.innerHTML = ''
            const list = document.createElement("div")
                list.classList.add('text-center')
            imageList.appendChild(list)
            for (let i = 0; i < this.files.length; i++) {
                const img = document.createElement("img")      
                img.src = URL.createObjectURL(this.files[i])
                img.classList.add('img')
                img.onload = () => { URL.revokeObjectURL(this.src) }
                list.appendChild(img)
                const info = document.createElement('p')
                info.innerHTML = this.files[i].name + `<br><b>` + formatBytes(this.files[i].size) + `</b><br>` +
                                 `<a href="#" id="imageRemove">( remove file )</a>`
                list.appendChild(info)
                tagId('imageRemove').addEventListener("click", (e) => {
                    imageElem.value = ''
                    if (imageSet.value) {
                        resetImageSet()
                    } else {
                        imageList.innerHTML = `<p>No files selected!</p>`
                    }
                    e.preventDefault(e)
                }, false)
                imageDelete.value = 0 // important!
            }
        }
    }
}

resetImageSet = () => {
    img = imageSet.value
    imageList.innerHTML = 
    `<div class="text-center">
        <img class="img" src="${img}" />
    </div>
    <p><a href="#" id="imageNull">( remove profile image )</a></p>`
}

dialogueImageNull = () => {
    let resp    = Object.create(null)
    resp.close  = true
    resp.title  = `<i class="fa fa-exclamation-triangle fa-wd"></i> Delete image`
    resp.body   = `Are you sure to update this school register without image?`
    resp.footer = `<button type="button" class="btn btn-default pull-left" data-dismiss="modal">No, close</button>
                   <button type="button" class="btn btn-danger" onclick="deleteProfileImage()">Yes, remove</button>`
    jqueryModal({show: true, data: resp})
}

deleteProfileImage = () => {
    imageDelete.value = 1
    imageList.innerHTML = `<p>No files selected!</p><p><a href="#" id="retrieveDeletedProfileImage">( retrieve deleted image )</a></p>`
    jqueryModal({show: false, data: null})    
}

retrieveDeletedProfileImage = () => {
    imageDelete.value = 0
    resetImageSet()
}

// Document Events Listener
document.addEventListener('click', (e) => {
    if (e.target && e.target.id == 'imageNull') dialogueImageNull()
    if (e.target && e.target.id == 'retrieveDeletedProfileImage') retrieveDeletedProfileImage()
    if (e.target && e.target.id == 'deleteRegisterDialogueBtn') deleteRegister()
    //e.preventDefault(e)
}, false)