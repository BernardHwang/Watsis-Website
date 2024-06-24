<div class="FeedbackForm">
	<button class="open-button" onclick="openForm()">Feedback</button>    
    <div class="container2" id="containerId">
        <form action="Contact.php" method="post" class="form-container">
            <h1>Feedback</h1>
                <label for="name"><b>Full Name</b></label>
                <input type="text" id="name" placeholder="Full name.." name="name" value="<?= htmlspecialchars($name) ?>">
                <div id="nameError" class="error"><?= $errors['name'] ?? '' ?></div>
                <label for="email"><b>Email Address</b></label>
                <input type="text" id="email" placeholder="Email Address.." name="email" value="<?= htmlspecialchars($email) ?>">
                <div id="emailError" class="error"><?= $errors['email'] ?? '' ?></div>

                <label for="phone"><b>Phone Number</b></label>
                <input type="text" id="phone" placeholder="Phone Number.." name="phone" value="<?= htmlspecialchars($phone) ?>">
                <div id="phoneError" class="error"><?= $errors['phone'] ?? '' ?></div>
                <label for="country"><b>Country</b></label>
                <select id="country" name="country">
                    <option value="china">China</option>
                    <option value="korea">Korea</option>
                    <option value="malaysia">Malaysia</option>		
                </select>
                <label for="subject"><b>Subject</b></label>
                <textarea id="subject" name="subject" placeholder="Write something.." style="height:100px" required></textarea>
            <div class="feedbackFormButton">
                <button type="submit" name="submitForm" class="btn">Submit</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Back</button>
            </div>
        </form>
    </div>

    <script>
		function openForm() {
		    document.getElementById("containerId").style.display = "block";
		}

		function closeForm() {
			document.getElementById("containerId").style.display = "none";	
		}
	</script>
</div>