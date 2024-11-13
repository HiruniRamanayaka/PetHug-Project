<?php
session_start();
if (!isset($_SESSION['dr_id'])) {
    header("Location: doctor_login.php");
    exit();
}

require '../connection.php'; 
include_once 'header_dr.php';

$doctor_id = $_SESSION['dr_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $consultation_id = $_POST['consultation_id'];
    if (isset($_POST['accept'])) {
        $conn->query("UPDATE consultation SET status='Accepted' WHERE consultation_id=$consultation_id");
    } elseif (isset($_POST['reject'])) {
        $conn->query("UPDATE consultation SET status='Canceled' WHERE consultation_id=$consultation_id");
    } elseif (isset($_POST['add_note'])) {
        $dr_notes = $_POST['details'];
        $conn->query("UPDATE consultation SET details='$dr_notes', status='Accepted' WHERE consultation_id=$consultation_id");
    }
}

$pendingConsultations = $conn->query("SELECT * FROM consultation WHERE dr_id=$doctor_id AND status='Pending'");
$upcomingConsultations = $conn->query("SELECT * FROM consultation WHERE dr_id=$doctor_id AND status='Accepted'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consultation Management</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f8ff; color: #333; }
        .container { width: 80%; margin: 20px auto; background-color: #bcd2fd; padding: 20px;}
        h2 { color: #1e90ff; }
        .table-container, .card-container { margin-top: 20px; }
        
        /* Pending Consultations Table */
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background-color: white;
            border: 1px solid #ddd;
        }
        th, td { 
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th { 
            background-color: #007bff;
            color: white;
         }
        .action-btn, .notes-btn {        
            padding: 8px 12px; 
            cursor: pointer; 
            border: none; 
            border-radius: 5px;
         }
        .accept-btn, .notes-btn{ 
            background-color: #1e90ff; 
            color: white; 
        }
        .reject-btn { 
            background-color: #ff6347; 
            color: white;
            margin-top: 3px;
         }

        /* Upcoming Consultations Cards */
        .card-container { display: flex; flex-wrap: wrap; gap: 20px; }
        .consultation-card { background-color: #ffffff; border: 1px solid #dcdcdc; width: 48%; padding: 20px; border-radius: 10px; position: relative; }
        .consultation-card img { width: 50px; height: 50px; border-radius: 50%; float: left; margin-right: 15px; }
        .consultation-card h3 { color: #1e90ff; margin-top: 0; }
        .consultation-card p { margin: 5px 0; color: #555; }
        .notes-input { display: block; width: 90%; padding: 8px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        .submit-note-btn, .whatsapp-btn { margin-top: 10px; padding: 8px 12px; border: none; border-radius: 5px; color: white; cursor: pointer; }
        .submit-note-btn { background-color: #1e90ff; }
        .whatsapp-btn { background-color: #25D366; }
/* Modal styling */
#detailsModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 60%;
    max-width: 600px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.3s ease;
}

.modal-content h2, .modal-content h3 {
    color: #1e90ff;
}

/* Close button styling */
.modal-content button {
    background-color: red;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
    margin-top: 15px;
   
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}


.modal-content button:hover {
    background-color: #1c86ee;
}


    </style>
    <script>
function viewDetails(petId) {
    document.getElementById('detailsModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('detailsModal').style.display = 'none';
}
</script>

</head>
<body>
<div class="container">

<h2>Upcoming Consultations</h2>
<div class="card-container">
    <?php while ($row = $upcomingConsultations->fetch_assoc()) :
        $user_id = $row['user_id'];
        $userResult = $conn->query("SELECT * FROM user WHERE user_id=$user_id");
        $user = $userResult->fetch_assoc();

        $pet_id = $row['pet_id'];
        $petResult = $conn->query("SELECT * FROM pet WHERE pet_id=$pet_id");
        $pet = $petResult->fetch_assoc();
    ?>
        <div class="consultation-card">
            <img src="../uploads/<?= $pet['pet_image'] ?>" alt="Pet Image">
            <h3><?= $row['consultation_id'] ?> - <?= $row['consultation_reason'] ?></h3>
            <p><strong>Owner:</strong> <?= $user['user_first_name'] . ' ' . $user['user_last_name'] ?></p>
            <p><strong>Date:</strong> <?= (new DateTime($row['consultation_time']))->format("Y-m-d") ?></p>
            <p><strong>Time:</strong> <?= (new DateTime($row['consultation_time']))->format("H:i:s") ?></p>
            <p><strong>Doctor Notes:</strong> <button onclick="viewDetails(<?= $pet_id ?>)">View Details  </button></p>

            <form method="post">
                <input type="hidden" name="consultation_id" value="<?= $row['consultation_id'] ?>">
                <input type="text" name="details" class="notes-input" placeholder="Add doctor notes">
                <button type="submit" name="add_note" class="submit-note-btn">Save Note</button>
            </form>
            
            <a href="https://wa.me/<?= $user['user_phone'] ?>" target="_blank">
                <button class="whatsapp-btn">Consult via WhatsApp</button>
            </a>
        </div>
    <?php endwhile; ?>
</div>
</div>

<div class="container">
    
    <h2>Pending Consultations</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Consultation ID</th>
                    <th>Reason</th>
                    <th>Pet Name</th>
                    <th>Owner Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $pendingConsultations->fetch_assoc()) :
         
                    $user_id = $row['user_id'];
            $userResult = $conn->query("SELECT * FROM user WHERE user_id=$user_id");
            $user = $userResult->fetch_assoc();
        
            $pet_id = $row['pet_id']; 
            $petResult = $conn->query("SELECT * FROM pet WHERE pet_id=$pet_id");
            $pet = $petResult->fetch_assoc();
 
                ?>
                    <tr>
                        <td><?= $row['consultation_id'] ?></td>
                        <td><?= $row['consultation_reason'] ?> </td>
                        <td><?= $pet['pet_name'] ?><br> <p><strong>Doctor Notes:</strong> <button class="notes-btn" onclick="viewDetails(<?= $row['pet_id'] ?>)">View Details  </button></p></td>

                        <td><?= $user['user_first_name'] . ' ' . $user['user_last_name'] ?></td>
                        <td><?= (new DateTime($row['consultation_time']))->format("Y-m-d") ?></td>
                        <td><?= (new DateTime($row['consultation_time']))->format("H:i:s") ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="consultation_id" value="<?= $row['consultation_id'] ?>">
                                <button type="submit" name="accept" class="action-btn accept-btn">Confirm</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="consultation_id" value="<?= $row['consultation_id'] ?>">
                                <button type="submit" name="reject" class="action-btn reject-btn">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

 <!-- Modal Structure -->
<div id="detailsModal" style="display: none;">
    <div class="modal-content">
        <h2>Pet Details</h2>
        
        <?php 
      
        if (isset($pet_id)) {
            $petResult = $conn->query("SELECT * FROM pet WHERE pet_id=$pet_id");
            $pet = $petResult->fetch_assoc();
            ?>
            <p><strong>Name:</strong> <?= $pet['pet_name'] ?></p>
            <p><strong>Age:</strong> <?= $pet['age'] ?> years</p>
            <p><strong>Weight:</strong> <?= $pet['weight'] ?> kg</p>
            <p><strong>Breed:</strong> <?= $pet['breed'] ?></p>
            <p><strong>Species:</strong> <?= $pet['species'] ?></p>
        <?php 
        } else { 
            echo "<p>No pet details available.</p>";
        } 
        ?>

        <h3>Doctor Notes</h3>
        <div style="max-height: 300px; overflow-y: auto;">
            <table>
                <tr>
                    <th>Date</th>
                    <th>Doctor Note</th>
                </tr>
                <?php
                // Fetch notes from both appointments and consultations for the specific pet
                $appointmentNotes = $conn->query("SELECT appointment_time, details FROM appointment WHERE pet_id=$pet_id AND details IS NOT NULL AND status='Completed'");
                $consultationNotes = $conn->query("SELECT consultation_time, details FROM consultation WHERE pet_id=$pet_id AND details IS NOT NULL AND status='Completed'");
                
                // Display appointment notes
                while ($note = $appointmentNotes->fetch_assoc()) {
                    echo "<tr><td>" . $note['appointment_time'] . "</td><td>" . $note['details'] . "</td></tr>";
                }

                // Display consultation notes
                while ($note = $consultationNotes->fetch_assoc()) {
                    echo "<tr><td>" . $note['consultation_time'] . "</td><td>" . $note['details'] . "</td></tr>";
                }
                
                // If no notes are available
                if ($appointmentNotes->num_rows === 0 && $consultationNotes->num_rows === 0) {
                    echo "<tr><td colspan='2'>No doctor notes available.</td></tr>";
                }
                ?>
            </table>
        </div>
        
        <button onclick="closeModal()">Close</button>
    </div>
</div>
</body>
</html>


<?php $conn->close(); ?>
<?php
include_once 'footer_dr.php';
?>