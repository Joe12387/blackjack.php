<?php

  /**
   *
   * Simulates 50,000 games of blackjack w/ a stand-on-17 player strategy.
   *
   * Example Output:
   *
   * Array
   * (
   *     [dealer_win] => 24245
   *     [player_win] => 20562
   *     [push] => 5193
   * )
   *
   **/

  require __DIR__ . '/blackjack.php';  
  
  $stats = []; 
  
  for ($i = 0; $i < 50000; $i++) {
    $blkjck = new blackjack();
  
    for ($player_hits = 0; $blkjck->status == "playing" and $blkjck->getPlayerScore() < 17; $player_hits++) {
      $blkjck->hit();
    }
    
    $blkjck->stand();
    
    if (!array_key_exists($blkjck->status, $stats)) $stats[$blkjck->status] = 0;
    $stats[$blkjck->status]++;
  
  }
  
  print_r($stats);
