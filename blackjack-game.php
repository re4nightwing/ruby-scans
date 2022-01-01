<?php
include 'db-conn.php';
$cardNumb = array(1,2,3,4,5,6,7,8,9,10,11);
$cardCreed = array("♠","♥","♣","♦");
$dealerHand = array();
$playerHand = array();

if(isset($_POST['round']) && isset($_POST['mail']) && isset($_POST['id'])){
    $round = $_POST['round'];
    $sendMail = $_POST['mail'];
    $sendUID = $_POST['id'];
    if($round == 1){
        array_push($dealerHand,returnRand($cardNumb,$cardCreed));
        array_push($playerHand,returnRand($cardNumb,$cardCreed));
    } elseif($round == 2){
        if(isset($_POST['action']) && isset($_POST['dealerdata']) && isset($_POST['playerdata'])){
            $sendAction = $_POST['action'];
            $sendDealer = $_POST['dealerdata'];
            $sendPlayer = $_POST['playerdata'];


            $strArrDealer = explode(",",$sendDealer);
            $strArrPlayer = explode(",",$sendPlayer);

            for ($i = 1; $i < count($strArrDealer); $i++) {
                $temp = hex2bin($strArrDealer[$i]);
                array_push($dealerHand,$temp);
            }

            for ($i = 1; $i < count($strArrPlayer); $i++) {
                $temp = hex2bin($strArrPlayer[$i]);
                array_push($playerHand,$temp);
            }


            if($sendAction == 'hit'){
                array_push($dealerHand,returnRand($cardNumb,$cardCreed));
                array_push($playerHand,returnRand($cardNumb,$cardCreed));
                $totDealer = getTotal($dealerHand);
                $totPlayer = getTotal($playerHand);

                if($totDealer > 21 && $totPlayer > 21){
                    echo "<b>You lost! The both went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert("You lost! The both went over 21 and busted.");
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_2HF1");
                            location.reload();
                        </script>
                        <?php
                    }
                } elseif($totDealer>21){
                    echo "<b>You win! The dealer went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+5, `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert('You win! The dealer went over 21 and busted.');
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_2HF2");
                            location.reload();
                        </script>
                        <?php
                    }
                } elseif($totPlayer>21){
                    echo "<b>You lost! The player went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert("You lost! The player went over 21 and busted.");
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_2HF3");
                            location.reload();
                        </script>
                        <?php
                    }
                }
            } elseif($sendAction == 'stand'){
                array_push($dealerHand,returnRand($cardNumb,$cardCreed));
                $totDealer = getTotal($dealerHand);
                $totPlayer = getTotal($playerHand);
                if($totDealer > 21 && $totPlayer > 21){
                    echo "<b>You lost! The both went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert("You lost! The both went over 21 and busted.");
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_2SF1");
                            location.reload();
                        </script>
                        <?php
                    }
                } elseif($totDealer>21){
                    echo "<b>You win! The dealer went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+5, `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert('You win! The dealer went over 21 and busted.');
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_2SF2");
                            location.reload();
                        </script>
                        <?php
                    }
                } elseif($totPlayer>21){
                    echo "<b>You lost! The player went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert("You lost! The player went over 21 and busted.");
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_2SF3");
                            location.reload();
                        </script>
                        <?php
                    }
                } else{
                    if($totDealer == $totPlayer){
                        echo "<b>You tied. You tied with the dealer.</b>";
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$sendMail]);
                            $dbh = null;
                            ?>
                            <script>
                                alert("You tied. You tied with the dealer.");
                                location.reload();
                            </script>
                            <?php
                        } catch(Exception $e){
                            ?>
                            <script>
                                alert("Something went wrong. Please try again!\nCode:Error_2SF4");
                                location.reload();
                            </script>
                            <?php
                        }
                    } elseif($totDealer > $totPlayer){
                        echo "<b>You lost! The dealer got $totDealer, the player got $totPlayer.</b><br>";
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$sendMail]);
                            $dbh = null;
                            ?>
                            <script>
                                alert('<?php echo "You lost! The dealer got $totDealer, the player got $totPlayer."?>');
                                location.reload();
                            </script>
                            <?php
                        } catch(Exception $e){
                            ?>
                            <script>
                                alert("Something went wrong. Please try again!\nCode:Error_2SF5");
                                location.reload();
                            </script>
                            <?php
                        }
                    } elseif($totDealer < $totPlayer){
                        echo "<b>You win! The player got $totPlayer, the dealer got $totDealer.</b><br>";
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+5, `blackjack_time`=now() WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$sendMail]);
                            $dbh = null;
                            ?>
                            <script>
                                alert('<?php echo "You win! The player got $totPlayer, the dealer got $totDealer."?>');
                                location.reload();
                            </script>
                            <?php
                        } catch(Exception $e){
                            ?>
                            <script>
                                alert("Something went wrong. Please try again!\nCode:Error_2SF6");
                                location.reload();
                            </script>
                            <?php
                        }
                    }
                }
            } elseif($sendAction == 'forfeit'){
                echo "<b>You ended the game. Nay loss, nay gain.</b><br>";
                $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                try{
                    $stmt->execute([$sendMail]);
                    $dbh = null;
                    ?>
                    <script>
                        alert("You ended the game. Nay loss, nay gain.");
                        location.reload();
                    </script>
                    <?php
                } catch(Exception $e){
                    ?>
                    <script>
                        alert("Something went wrong. Please try again!\nCode:Error_2FF1");
                        location.reload();
                    </script>
                    <?php
                }
            }
        } else{
            echo "action not set";
            ?>
            <script>
                alert("Action not set Error");
                window.location.href = "user-logout.php";
            </script>
            <?php
        }
    } elseif($round == 3){
        if(isset($_POST['action']) && isset($_POST['dealerdata']) && isset($_POST['playerdata'])){
            $sendAction = $_POST['action'];
            $sendDealer = $_POST['dealerdata'];
            $sendPlayer = $_POST['playerdata'];


            $strArrDealer = explode(",",$sendDealer);
            $strArrPlayer = explode(",",$sendPlayer);

            for ($i = 1; $i < count($strArrDealer); $i++) {
                $temp = hex2bin($strArrDealer[$i]);
                array_push($dealerHand,$temp);
            }

            for ($i = 1; $i < count($strArrPlayer); $i++) {
                $temp = hex2bin($strArrPlayer[$i]);
                array_push($playerHand,$temp);
            }


            if($sendAction == 'hit'){
                array_push($dealerHand,returnRand($cardNumb,$cardCreed));
                array_push($playerHand,returnRand($cardNumb,$cardCreed));
                $totDealer = getTotal($dealerHand);
                $totPlayer = getTotal($playerHand);

                if($totDealer > 21 && $totPlayer > 21){
                    echo "<b>You lost! The both went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert("You lost! The both went over 21 and busted.");
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_3HF1");
                            location.reload();
                        </script>
                        <?php
                    }
                } elseif($totDealer>21){
                    echo "<b>You win! The dealer went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+5, `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert('You win! The dealer went over 21 and busted.');
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_3HF2");
                            location.reload();
                        </script>
                        <?php
                    }
                } elseif($totPlayer>21){
                    echo "<b>You lost! The player went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert("You lost! The player went over 21 and busted.");
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_3HF3");
                            location.reload();
                        </script>
                        <?php
                    }
                } else{
                    if($totDealer == $totPlayer){
                        echo "<b>Both tied. Nothing happeneth.</b>";
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$sendMail]);
                            $dbh = null;
                            ?>
                            <script>
                                alert("Both did tie. Nothing hath happened\n-Shakespearean");
                                location.reload();
                            </script>
                            <?php
                        } catch(Exception $e){
                            ?>
                            <script>
                                alert("Something went wrong. Please try again!\nCode:Error_3HF4");
                                location.reload();
                            </script>
                            <?php
                        }
                    } elseif($totDealer > $totPlayer){
                        echo "<b>You lost! The dealer got $totDealer, the player got $totPlayer.</b><br>";
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$sendMail]);
                            $dbh = null;
                            ?>
                            <script>
                                alert('<?php echo "You lost! The dealer got $totDealer, the player got $totPlayer."; ?>');
                                location.reload();
                            </script>
                            <?php
                        } catch(Exception $e){
                            ?>
                            <script>
                                alert("Something went wrong. Please try again!\nCode:Error_3HF5");
                                location.reload();
                            </script>
                            <?php
                        }
                    } elseif($totDealer < $totPlayer){
                        echo "<b>You win! The player got $totPlayer, the dealer got $totDealer.</b><br>";
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+5, `blackjack_time`=now() WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$sendMail]);
                            $dbh = null;
                            ?>
                            <script>
                                alert('<?php echo "You win! The player got $totPlayer, the dealer got $totDealer."; ?>');
                                location.reload();
                            </script>
                            <?php
                        } catch(Exception $e){
                            ?>
                            <script>
                                alert("Something went wrong. Please try again!\nCode:Error_3HF6");
                                location.reload();
                            </script>
                            <?php
                        }
                    }
                }
            } elseif($sendAction == 'stand'){
                array_push($dealerHand,returnRand($cardNumb,$cardCreed));
                $totDealer = getTotal($dealerHand);
                $totPlayer = getTotal($playerHand);

                if($totDealer > 21 && $totPlayer > 21){
                    echo "<b>You lost! The both went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert("You lost! The both went over 21 and busted.");
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_3SF1");
                            location.reload();
                        </script>
                        <?php
                    }
                } elseif($totDealer>21){
                    echo "<b>You win! The dealer went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+5, `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert('You win! The dealer went over 21 and busted.');
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_3SF2");
                            location.reload();
                        </script>
                        <?php
                    }
                } elseif($totPlayer>21){
                    echo "<b>You lost! The player went over 21 and busted.</b><br>";
                    $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                    try{
                        $stmt->execute([$sendMail]);
                        $dbh = null;
                        ?>
                        <script>
                            alert("You lost! The player went over 21 and busted.");
                            location.reload();
                        </script>
                        <?php
                    } catch(Exception $e){
                        ?>
                        <script>
                            alert("Something went wrong. Please try again!\nCode:Error_3SF3");
                            location.reload();
                        </script>
                        <?php
                    }
                } else{
                    if($totDealer == $totPlayer){
                        echo "<b>You tied. You tied with the dealer.</b>";
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$sendMail]);
                            $dbh = null;
                            ?>
                            <script>
                                alert("Both did tie. Nothing hath happened\n-Shakespearean");
                                location.reload();
                            </script>
                            <?php
                        } catch(Exception $e){
                            ?>
                            <script>
                                alert("Something went wrong. Please try again!\nCode:Error_3SF4");
                                location.reload();
                            </script>
                            <?php
                        }
                    } elseif($totDealer > $totPlayer){
                        echo "<b>You lost! The dealer got $totDealer, the player got $totPlayer.</b><br>";
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$sendMail]);
                            $dbh = null;
                            ?>
                            <script>
                                alert('<?php echo "You lost! The dealer got $totDealer, the player got $totPlayer."; ?>');
                                location.reload();
                            </script>
                            <?php
                        } catch(Exception $e){
                            ?>
                            <script>
                                alert("Something went wrong. Please try again!\nCode:Error_3SF5");
                                location.reload();
                            </script>
                            <?php
                        }
                    } elseif($totDealer < $totPlayer){
                        echo "<b>You win! The player got $totPlayer, the dealer got $totDealer.</b><br>";
                        $stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+5, `blackjack_time`=now() WHERE `user_mail`=?");
                        try{
                            $stmt->execute([$sendMail]);
                            $dbh = null;
                            ?>
                            <script>
                                alert('<?php echo "You win! The player got $totPlayer, the dealer got $totDealer."; ?>');
                                location.reload();
                            </script>
                            <?php
                        } catch(Exception $e){
                            ?>
                            <script>
                                alert("Something went wrong. Please try again!\nCode:Error_3SF6");
                                location.reload();
                            </script>
                            <?php
                        }
                    }
                }
            } elseif($sendAction == 'forfeit'){
                echo "<b>You ended the game. Nay loss, nay gain.</b><br>";
                $stmt = $dbh->prepare("UPDATE `user_details` SET `blackjack_time`=now() WHERE `user_mail`=?");
                try{
                    $stmt->execute([$sendMail]);
                    $dbh = null;
                    ?>
                    <script>
                        alert("You ended the game. Nay loss, nay gain.");
                        location.reload();
                    </script>
                    <?php
                } catch(Exception $e){
                    ?>
                    <script>
                        alert("Something went wrong. Please try again!\nCode:Error_3FF1");
                        location.reload();
                    </script>
                    <?php
                }
            }
        } else{
            echo "action not set";
            ?>
            <script>
                alert("Action not set Error");
                window.location.href = "user-logout.php";
            </script>
            <?php
        }
    }
    printUser($dealerHand,"Dealer",$round);
    printUser($playerHand,"Player",1);
    hideArray($dealerHand,"dealer");
    hideArray($playerHand,"player");
    printBtn($round);
    $dbh = null;
}

function returnRand($cardNumb, $cardCreed) {
    $number = array_rand($cardNumb,1);
    $creed = array_rand($cardCreed,1);
    $val = "$cardCreed[$creed]-$cardNumb[$number]";
    return($val);
}

function getTotal($arr){
    $total = 0;
    foreach( $arr as $card ) {
        $number = explode("-",$card);
        $total += $number[1];
    }
    return $total;
}

function printUser($hand,$user,$round){
    echo $user.": ";
    $total = 0;
    if($round == 1){
        foreach( $hand as $card ) {
            echo "<span class='badge bg-light text-dark mx-1'>$card</span>";
            $number = explode("-",$card);
            $total += $number[1];
        }
        echo "<br>Total: $total<br>";
    } else{
        $count = 0;
        foreach( $hand as $card ) {
            if($count == 0){
                echo "<span class='badge bg-light text-dark mx-1'>$card</span>";
                $number = explode("-",$card);
                $total += $number[1];
                $count++;
            } else{
                echo "<span class='badge bg-light text-dark mx-1'>??</span>";
                $number = explode("-",$card);
                $total += $number[1]; 
            }
        }
        echo "<br>Total: ??<br>";
    }
    
}

function printBtn($round){
    if($round == 1){
        echo "<div class='row justify-content-center'>
        <div class='col-md-3 col-sm-5 col-8'>
            <button class='btn btn-info' id='hit-2' onclick='nextRound(this.id)'>Hit</button>
        </div>
        <div class='col-md-3 col-sm-5 col-8'>
            <button class='btn btn-info' id='stand-2' onclick='nextRound(this.id)'>Stand</button>
        </div>
        <div class='col-md-3 col-sm-5 col-8'>
            <button class='btn btn-info' id='forfeit-2' onclick='nextRound(this.id)'>Forfeit</button>
        </div>
    </div>";
    } elseif($round == 2){
        echo "<div class='row justify-content-center'>
        <div class='col-md-3 col-sm-5 col-8'>
            <button class='btn btn-info' id='hit-3' onclick='nextRound(this.id)'>Hit</button>
        </div>
        <div class='col-md-3 col-sm-5 col-8'>
            <button class='btn btn-info' id='stand-3' onclick='nextRound(this.id)'>Stand</button>
        </div>
        <div class='col-md-3 col-sm-5 col-8'>
            <button class='btn btn-info' id='forfeit-3' onclick='nextRound(this.id)'>Forfeit</button>
        </div>
    </div>";
    }
}

function hideArray($hand, $field){
    $valstr = "@@method";
    foreach($hand as $card){
        $hashedtxt = bin2hex($card);
        $valstr = $valstr.",".$hashedtxt;
    }
    echo "<input type='text' name='".$field."' value='".$valstr."' hidden>";
}
?>