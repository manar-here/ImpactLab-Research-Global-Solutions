<?php
include 'db.php';

// Handle inserting a new innovation idea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_idea'])) {
    $problem = $conn->real_escape_string($_POST['global_problem']);
    $idea = $conn->real_escape_string($_POST['research_idea']);
    $category = $conn->real_escape_string($_POST['category']);
    $score = intval($_POST['impact_score']);
    $sdg = $conn->real_escape_string($_POST['sdg']);
    $status = "Under Review";

    $sql = "INSERT INTO innovations (global_problem, research_idea, category, impact_score, sdg, status) 
            VALUES ('$problem', '$idea', '$category', $score, '$sdg', '$status')";
    $conn->query($sql);
    header("Location: index.php");
    exit();
}

// Handle toggling the status between Under Review and Accepted
if (isset($_GET['toggle_id'])) {
    $id = intval($_GET['toggle_id']);
    $result = $conn->query("SELECT status FROM innovations WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $new_status = ($row['status'] === 'Under Review') ? 'Accepted' : 'Under Review';
        $conn->query("UPDATE innovations SET status = '$new_status' WHERE id = $id");
    }
    header("Location: index.php");
    exit();
}

// Fetch dashboard statistics
$total_ideas = $conn->query("SELECT COUNT(*) as count FROM innovations")->fetch_assoc()['count'];
$accepted_ideas = $conn->query("SELECT COUNT(*) as count FROM innovations WHERE status = 'Accepted'")->fetch_assoc()['count'];
$review_ideas = $conn->query("SELECT COUNT(*) as count FROM innovations WHERE status = 'Under Review'")->fetch_assoc()['count'];

// Fetch all innovations for the table
$result = $conn->query("SELECT * FROM innovations ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>ImpactLab – Research & Global Solutions</title>
    <style>
        :root {
            --primary: #2563eb;
            --success: #16a34a;
            --warning: #ca8a04;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-color: #1e293b;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
        }
        header {
            text-align: center;
            margin-bottom: 30px;
        }
        header h1 {
            color: var(--primary);
            margin-bottom: 5px;
        }
        header p {
            color: #64748b;
            font-size: 1.1rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            text-align: center;
        }
        .stat-card h3 {
            margin: 0;
            color: #64748b;
            font-size: 0.95rem;
        }
        .stat-card .number {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary);
            margin-top: 10px;
        }
        .form-container {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            margin-bottom: 40px;
        }
        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 15px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .form-group input, .form-group select {
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.95rem;
        }
        .btn-submit {
            grid-column: 1 / -1;
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background-color: #1d4ed8;
        }
        .table-container {
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            overflow-x: auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.95rem;
        }
        th {
            background-color: #f1f5f9;
            font-weight: 600;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }
        .badge-review {
            background-color: #fef08a;
            color: #854d0e;
        }
        .badge-accepted {
            background-color: #bbf7d0;
            color: #166534;
        }
        .btn-toggle {
            text-decoration: none;
            background: #e2e8f0;
            color: #334155;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-toggle:hover {
            background: #cbd5e1;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>🌍 ImpactLab</h1>
        <p>Research & Global Solutions Incubator</p>
    </header>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Research Ideas</h3>
            <div class="number"><?php echo $total_ideas; ?></div>
        </div>
        <div class="stat-card">
            <h3>Accepted Innovations</h3>
            <div class="number" style="color: var(--success);"><?php echo $accepted_ideas; ?></div>
        </div>
        <div class="stat-card">
            <h3>Under Review</h3>
            <div class="number" style="color: var(--warning);"><?php echo $review_ideas; ?></div>
        </div>
    </div>

    <div class="form-container">
        <h2>💡 Submit a New Global Innovation</h2>
        <form method="POST" action="">
            <div class="form-grid">
                <div class="form-group">
                    <label>Global Problem</label>
                    <input type="text" name="global_problem" placeholder="e.g., Water Scarcity" required>
                </div>
                <div class="form-group">
                    <label>Research Idea</label>
                    <input type="text" name="research_idea" placeholder="e.g., AI Water Network" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="🌍 Environment">🌍 Environment</option>
                        <option value="🩺 Healthcare">🩺 Healthcare</option>
                        <option value="🚀 Space">🚀 Space</option>
                        <option value="📚 Education">📚 Education</option>
                        <option value="🌊 Oceans">🌊 Oceans</option>
                        <option value="⚡ Energy">⚡ Energy</option>
                        <option value="🍃 Climate">🍃 Climate</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Impact Score (1-100)</label>
					<input type="number" name="impact_score" min="1" max="100" placeholder="95" required>
                </div>
                <div class="form-group">
                    <label>UN Sustainable Development Goal (SDG)</label>
                    <select name="sdg" required>
                        <option value="Clean Water & Sanitation">Clean Water & Sanitation</option>
                        <option value="Quality Education">Quality Education</option>
                        <option value="Climate Action">Climate Action</option>
                        <option value="Good Health & Well-being">Good Health & Well-being</option>
                        <option value="Affordable & Clean Energy">Affordable & Clean Energy</option>
                        <option value="Life Below Water">Life Below Water</option>
                    </select>
                </div>
                <button type="submit" name="submit_idea" class="btn-submit">Submit Innovation</button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <h2>📊 Innovations Tracking Table</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Global Problem</th>
                    <th>Research Idea</th>
                    <th>Category</th>
                    <th>Score</th>
                    <th>SDG Target</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['global_problem']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['research_idea']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><strong><?php echo $row['impact_score']; ?></strong></td>
                            <td><small><?php echo htmlspecialchars($row['sdg']); ?></small></td>
                            <td>
                                <?php if ($row['status'] === 'Accepted'): ?>
                                    <span class="badge badge-accepted">🟢 Accepted</span>
                                <?php else: ?>
                                    <span class="badge badge-review">🟡 Under Review</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?toggle_id=<?php echo $row['id']; ?>" class="btn-toggle">Toggle Status</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: #64748b;">No innovations submitted yet. Be the first to add one!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>