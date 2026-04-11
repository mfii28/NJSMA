<div class="sidebar">

  <div class="sidebar-nav shadow-sm mb-4">
    <h4>Search News</h4>
    <form action="search.php" class="mt-3">
      <div class="input-group">
        <input type="text" name="searchtitle" class="form-control" placeholder="Search..." required>
        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
      </div>
    </form>
  </div>

  <div class="sidebar-nav shadow-sm mb-4">
    <h4>Categories</h4>
    <ul class="list-unstyled mb-0 mt-3">
      <?php 
      $query = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory");
      while($row = mysqli_fetch_array($query)) { 
      ?>
        <li class="mb-2">
          <a href="category.php?catid=<?= $row['id'] ?>" class="text-decoration-none text-dark"><i class="bi bi-chevron-right me-2 text-primary small"></i> <?= htmlspecialchars($row['CategoryName']) ?></a>
        </li>
      <?php } ?>
    </ul>
  </div>

  <div class="sidebar-nav shadow-sm mb-4">
    <h4>Recent News</h4>
    <div class="mt-3">
      <?php
      $query = mysqli_query($con, "SELECT p.PostingDate, p.id, p.PostTitle FROM tblposts p WHERE p.Is_Active = 1 ORDER BY p.PostingDate DESC LIMIT 5");
      while ($row = mysqli_fetch_array($query)) {
      ?>
        <div class="mb-3 border-bottom pb-2">
          <h6 class="mb-1"><a href="blogs.php?id=<?= $row['id'] ?>" class="text-dark text-decoration-none fw-bold small"><?= htmlspecialchars($row['PostTitle']) ?></a></h6>
          <span class="text-muted" style="font-size: 11px;"><i class="bi bi-calendar3 me-1"></i> <?= date('M d, Y', strtotime($row['PostingDate'])) ?></span>
        </div>
      <?php } ?>
    </div>
  </div>

</div>