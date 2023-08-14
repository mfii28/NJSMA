
<div class="sidebar ">

<div class="sidebar-item search-form">
  <h3 class="sidebar-title">Search</h3>
  <form action="search.php" class="mt-3">
    <input type="text" name="searchtitle" placeholder="Search for..." required>
    <button type="submit"><i class="bi bi-search"></i></button>
  </form>
</div><!-- End sidebar search formn-->

<div class="sidebar-item  categories">
  <h3 class="sidebar-title">Categories</h3>
  <ul class="mt-3">
  <?php $query=mysqli_query($con,"select id,CategoryName from tblcategory");
        while($row=mysqli_fetch_array($query))
   { ?>

<li>
        <a href="category.php?catid=<?php echo htmlentities($row['id'])?>"><?php echo htmlentities($row['CategoryName']);?></a>
      </li>
<?php } ?>
  </ul>
</div><!-- End sidebar categories-->

<div class="sidebar-item recent-posts">
  <h3 class="sidebar-title">Recent Posts</h3>

  <div class="mt-3">


  <?php
$query=mysqli_query($con,"select tblposts.PostingDate as postingdate, tblposts.id as pid,tblposts.PostTitle as posttitle from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId limit 8");
while ($row=mysqli_fetch_array($query)) {

?>




      <div  class="post-item mt-3">
       >
      <div>
        <h4><a href="blogPreview.php?nid=<?php echo htmlentities($row['pid'])?>"><?php echo htmlentities($row['posttitle']);?></a></h4>
        <time datetime="2020-01-01"> Posted on <?php echo htmlentities($row['postingdate']);?></time>
      </div>
    </div><!-- End recent post item-->



      <?php } ?>


    

  </div>

</div><!-- End sidebar recent posts-->
<!-- 
<div class="sidebar-item tags">
  <h3 class="sidebar-title">Tags</h3>
  <ul class="mt-3">
    <li><a href="#">App</a></li>
    <li><a href="#">IT</a></li>
    <li><a href="#">Business</a></li>
    <li><a href="#">Mac</a></li>
    <li><a href="#">Design</a></li>
    <li><a href="#">Office</a></li>
    <li><a href="#">Creative</a></li>
    <li><a href="#">Studio</a></li>
    <li><a href="#">Smart</a></li>
    <li><a href="#">Tips</a></li>
    <li><a href="#">Marketing</a></li>
  </ul>
</div>End sidebar tags -->

</div><!-- End Blog Sidebar -->

</div>