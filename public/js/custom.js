function setSwalMessage(mode = 'success', title = 'Success', text = 'Data Save Successfully!') {
    Swal.fire({
        icon: mode,
        title: title,
        text: text,
    })
}