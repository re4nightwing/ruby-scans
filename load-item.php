<?php
include 'db-conn.php';
    if(isset($_POST['searchVal'])){
        $search_q = $_POST['searchVal'];
        $author_q = $_POST['authorVal'];
        $year_q = $_POST['yearVal'];
        $sort_q = $_POST['sortVal'];
        $status_q = $_POST['statusVal'];
        $type_q = $_POST['typeVal'];
        $genre_q = $_POST['genreVal'];
    } else{
        ?>
        <script>
            window.location.href = "search-manga.php";
        </script>
        <?php
    }
    if($search_q == ''){
        $search_q = "%";
    }
    if($author_q == ''){
        $author_q = "%";
    }
    if($year_q == ''){
        $year_q = "%";
    }
    if($sort_q == ''){
        $sort_q = "asc";
    }
    if($status_q == '' || $status_q == 'all'){
        $status_q = "%";
    }
    if($type_q == '' || $type_q == 'all'){
        $type_q = "%";
    }
    if($genre_q == '' || $genre_q == 'all'){
        $genre_q = "%";
    }

    if($sort_q == 'asc'){
        $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_title` ASC LIMIT 100';
    } elseif($sort_q == 'desc'){
        $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_title` DESC LIMIT 100';
    } elseif($sort_q == 'new'){
        $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_release` DESC LIMIT 100';
    } elseif($sort_q == 'old'){
        $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_release` ASC LIMIT 100';
    } elseif($sort_q == 'most'){
        $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_views` DESC LIMIT 100';
    } elseif($sort_q == 'least'){
        $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_views` ASC LIMIT 100';
    } else{
        $final_query = 'SELECT * FROM `magazine-details` WHERE (`mag_title` LIKE :titlekey OR `mag_alt_title` LIKE :titlekey) AND `mag_author` LIKE :authorkey AND `mag_release` LIKE :yearkey AND `mag_status` LIKE :statuskey AND `mag_type` LIKE :typekey AND `mag_genre` LIKE :genrekey ORDER BY `mag_title` ASC LIMIT 100';
    }

    $final_statement=$dbh->prepare($final_query);
    $final_statement->bindValue(':titlekey','%'.$search_q.'%');
    $final_statement->bindValue(':authorkey','%'.$author_q.'%');
    $final_statement->bindValue(':yearkey','%'.$year_q.'%');
    $final_statement->bindValue(':statuskey','%'.$status_q.'%');
    $final_statement->bindValue(':typekey','%'.$type_q.'%');
    $final_statement->bindValue(':genrekey','%'.$genre_q.'%');
    $final_statement->execute();
    //$final_statement->debugDumpParams();
    $result = $final_statement->fetchAll();
    echo "<div class='row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 g-4'>";
    if($final_statement->rowCount() > 0){
        foreach($result as $row){
            $genre_arr = explode(',',$row['mag_genre']);
            $clean_genre_arr = array_filter($genre_arr);
            $img_arr = explode('.',$row['mag_cover']);
            ?>
            <div class="col">
                <div class="card h-100">
                    <a href="magazine-details.php?mag-id=<?php echo $row['mag_id'];?>">
                        <img src="https://i.imgur.com/<?php echo $img_arr[0]."b.".$img_arr[1];?>" class="card-img-top" alt="<?php echo $row['mag_title'];?>">
                    </a>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['mag_title']." (".$row['mag_release'].")";?></h5>
                    <span class="badge bg-success"><?php echo $row['mag_status']?></span>
                    <p class="card-text">
                        <?php
                            foreach($clean_genre_arr as $genrename){
                                echo "<a class='btn-link' href='search-manga.php?searchq=&authorq=&yearq=&sortq=asc&statusq=all&typeq=all&genreq=".$genrename."'>$genrename</a> ";
                            }
                        ?>
                        <br><b>Author/s: </b><?php echo $row['mag_author']?>
                    </p>
                    <h6 class="badge rounded-pill bg-warning text-dark"><b><i><?php echo $row['mag_type']?></i></b></h6>
                </div>
                </div>
            </div>
            <?php
        }
    } else{
        echo "<div class='text-center mx-auto'>";
        echo "<img src='img/detective-404.png' class='img-fluid'><br>";
        echo "<a href='search-manga.php' class='btn btn-outline-danger mt-3'>Reset Filter</a>";
        echo "</div>";
    }
    echo "</div>";
    $dbh = null;
?>