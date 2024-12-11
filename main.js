console.log("I am js!");

function populateForm(resource) {


    document.querySelector('#resourceForm').action = 'resources.php';
    document.querySelector('input[name="action"]').value = 'update'; 
    document.querySelector('input[name="id"]').value = resource.id; 
    document.querySelector('#title').value = resource.title; 
    document.querySelector('#type').value = resource.type;
    document.querySelector('#content').value = resource.content;

    // Change the button text to "Update Resource"
    document.querySelector('button[type="submit"]').textContent = 'Update Resource';
}

// Ssubmitting the form, handling the kudos (I think it sounds better than like, more personal), and confirming actions

document.addEventListener('DOMContentLoaded', () => {
    
    const form = document.querySelector('#resourceForm');
    const submitButton = form.querySelector('button[type="submit"]');

    submitButton.addEventListener('click', (event) => {
        const action = submitButton.value;
        const confirmMessage = action === 'insert' ? 
            'Are you sure you want to add this resource?' : 
            'Are you sure you want to submit this update?';

        if (!confirm(confirmMessage)) {
            event.preventDefault();
        }
    });

    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            if (!confirm('Are you sure you want to delete this resource?')) {
                e.preventDefault();
            }
        });
    });

    const kudosButtons = document.querySelectorAll('.kudos-btn');
    kudosButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const resourceId = button.dataset.resourceId;
            const xhrKudos = new XMLHttpRequest();

            xhrKudos.onreadystatechange = () => {
                if (xhrKudos.readyState === XMLHttpRequest.DONE && xhrKudos.status === 200) {
                    const responseJSON = JSON.parse(xhrKudos.responseText);
                    if (responseJSON.success) {
                        alert('You gave this a kudos!');
                        const kudosCount = button.querySelector('.kudos-count');
                        kudosCount.textContent = responseJSON.kudosCount;
                    } else {
                        alert('Error updating kudos. Please try again.');
                    }
                }
            };

            xhrKudos.open('POST', 'update-kudos-ajax.php', true);
            xhrKudos.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhrKudos.send(`resource_id=${resourceId}`);
        });
    });
});



// Contact us form submission

document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');

    contactForm.addEventListener('submit', function (e) {
        e.preventDefault();  

        const formData = new FormData(contactForm);

        console.log('Sending data:', formData); 

        fetch('contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())  
        .then(data => {
            console.log('Response:', data);  

            if (data.success) {
                successMessage.style.display = 'block';
                errorMessage.style.display = 'none';
                contactForm.reset();
            } else {
                successMessage.style.display = 'none';
                errorMessage.style.display = 'block';
                errorMessage.textContent = data.message; 
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'There was an error processing your request.';
        });
    });
});



//footer thing for funsies




function showMessage(type) {
    
    document.getElementById('message-container').style.display = 'block';

    
    let messageElement = document.querySelector("#message-container p");

   
    if (type === 'privacy') {
        messageElement.textContent = "You clicked Privacy Policy! Do you really want to read that? Liar. But yeah, the idea behind this website is privacy for female gamers.";
    } else if (type === 'terms') {
        messageElement.textContent = "You clicked Terms of Service! Do you really want to read that? Liar. Be warned, violating terms will get you kicked out mercilessly.";
    }
}


