document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-button");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const categoryId = this.getAttribute("data-id");

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: `Data ${this.getAttribute(
                    "data-nama"
                )} ini akan dihapus permanen!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e3342f",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "bg-red-600 text-white",
                    cancelButton: "bg-gray-300 text-gray-800",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    document
                        .getElementById("delete-form-" + categoryId)
                        .submit();
                }
            });
        });
    });
});

// document.addEventListener("DOMContentLoaded", function () {
//     const deleteButtons = document.querySelectorAll(".delete-button");

//     deleteButtons.forEach((button) => {
//         button.addEventListener("click", function () {
//             const menuId = this.getAttribute("data-id");

//             Swal.fire({
//                 title: "Yakin ingin menghapus?",
//                 text: "Data menu ini akan dihapus permanen!",
//                 icon: "warning",
//                 showCancelButton: true,
//                 confirmButtonColor: "#e3342f",
//                 cancelButtonColor: "#6c757d",
//                 confirmButtonText: "Ya, hapus!",
//                 cancelButtonText: "Batal",
//                 customClass: {
//                     confirmButton: "bg-red-600 text-white",
//                     cancelButton: "bg-gray-300 text-gray-800",
//                 },
//             }).then((result) => {
//                 if (result.isConfirmed) {
//                     document.getElementById("delete-form-" + menuId).submit();
//                 }
//             });
//         });
//     });
// });
