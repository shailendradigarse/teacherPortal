import 'bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {

    const alertSuccess = document.getElementById('alertSuccess');
    const alertError = document.getElementById('alertError');

    function showAlert(message, type = 'danger') {
        const alertElement = type === 'success' ? alertSuccess : alertError;

        if (alertElement) {
            alertElement.textContent = message;
            alertElement.classList.remove('d-none');
            alertElement.classList.add('show');

            setTimeout(() => {
                alertElement.classList.remove('show');
                setTimeout(() => alertElement.classList.add('d-none'), 150); // Allow fade-out effect before hiding
            }, 5000); // Show alert for 5 seconds
        } else {
            console.error('Alert element not found');
        }
    }

    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            row.querySelector('.name-text').classList.add('d-none');
            row.querySelector('.subject-text').classList.add('d-none');
            row.querySelector('.marks-text').classList.add('d-none');

            row.querySelector('.name-input').classList.remove('d-none');
            row.querySelector('.subject-input').classList.remove('d-none');
            row.querySelector('.marks-input').classList.remove('d-none');

            row.querySelector('.edit-button').classList.add('d-none');
            row.querySelector('.delete-button').classList.add('d-none');
            row.querySelector('.save-button').classList.remove('d-none');
            row.querySelector('.cancel-button').classList.remove('d-none');
        });
    });

    document.querySelectorAll('.cancel-button').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            row.querySelector('.name-text').classList.remove('d-none');
            row.querySelector('.subject-text').classList.remove('d-none');
            row.querySelector('.marks-text').classList.remove('d-none');

            row.querySelector('.name-input').classList.add('d-none');
            row.querySelector('.subject-input').classList.add('d-none');
            row.querySelector('.marks-input').classList.add('d-none');

            row.querySelector('.edit-button').classList.remove('d-none');
            row.querySelector('.delete-button').classList.remove('d-none');
            row.querySelector('.save-button').classList.add('d-none');
            row.querySelector('.cancel-button').classList.add('d-none');
        });
    });

    document.querySelectorAll('.save-button').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const id = this.getAttribute('data-student-id');
            const name = row.querySelector('.name-input').value;
            const subject = row.querySelector('.subject-input').value;
            const marks = row.querySelector('.marks-input').value;

            fetch(`/students/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, subject, marks })
            }).then(response => response.json())
              .then(data => {
                console.log(data, "data")
                  if (data.success) {
                      row.querySelector('.name-text').textContent = name;
                      row.querySelector('.subject-text').textContent = subject;
                      row.querySelector('.marks-text').textContent = marks;

                      row.querySelector('.name-text').classList.remove('d-none');
                      row.querySelector('.subject-text').classList.remove('d-none');
                      row.querySelector('.marks-text').classList.remove('d-none');

                      row.querySelector('.name-input').classList.add('d-none');
                      row.querySelector('.subject-input').classList.add('d-none');
                      row.querySelector('.marks-input').classList.add('d-none');

                      row.querySelector('.edit-button').classList.remove('d-none');
                      row.querySelector('.delete-button').classList.remove('d-none');
                      row.querySelector('.save-button').classList.add('d-none');
                      row.querySelector('.cancel-button').classList.add('d-none');

                      showAlert('Student updated successfully', 'success');
                  } else {
                      showAlert(data.error);
                  }
              }).catch(error => {
                  showAlert('Error: ' + error);
              });
        });
    });

    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-student-id');
            // Show Bootstrap confirmation modal
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');

            confirmDeleteButton.onclick = () => {
                fetch(`/students/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          this.closest('tr').remove();
                          confirmModal.hide();
                          showAlert('Student deleted successfully', 'success');
                      } else {
                          showAlert('Failed to delete student');
                      }
                  }).catch(error => {
                      showAlert('Error: ' + error.message);
                  });
            };

            confirmModal.show();
        });
    });

    document.getElementById('addStudentForm').addEventListener('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        fetch('/students', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  showAlert('Student added successfully', 'success');
                  location.reload();
              } else {
                  showAlert('Failed to add student');
              }
          }).catch(error => {
              showAlert('Error: ' + error.message);
          });
    });

    // Ensure alert remains visible when the modal closes
    const confirmModal = document.getElementById('confirmDeleteModal');
    confirmModal.addEventListener('hidden.bs.modal', function () {
        // Check if alert exists
        // if (alertSuccess) {
        //     showAlert('Student deleted successfully', 'success');
        // }
        // if (alertError) {
        //     showAlert('error while deleting', 'error');
        // }
    });
});
