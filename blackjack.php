<?php
  
  class blackjack {
    
    function __construct() {
      
      $this->status = 'playing';
        
      $a = ['A','2','3','4','5','6','7','8','9','10','J','Q','K'];
      $b = ['C','D','H','S'];
      
      $cards = [];
      
      for ($x = 0; $x < count($a); $x++) {
    
        for ($y = 0; $y < count($b); $y++) {
        
          $cards[] = [
            'rank' => $a[$x],
            'suit' => $b[$y]
          ];
        
        }
        
      }
      
      shuffle($cards);
      
      $this->cards = $cards;
      
      $this->dealer_up_card = $this->getCard();
      
      $this->dealer_cards = [$this->dealer_up_card, $this->getCard()];
      $this->player_cards = [$this->getCard(), $this->getCard()];
                  
    }
    
    function getCard() {
      
      return array_pop($this->cards);
      
    }
    
    function getDealerScore() {
      
      return $this->valueCards($this->dealer_cards);
      
    }

    function getPlayerScore() {
      
      return $this->valueCards($this->player_cards);
      
    }
    
    function hit() {
      
      $this->player_cards[] = $this->getCard();
      
      $val = $this->getPlayerScore();
      
      if ($val > 21) {
        
        $this->status = 'dealer_win';
                
      }
            
    }

    function stand() {
      
      if ($this->status != 'playing') {
        return;
      }
      
      while ($this->getDealerScore() < 17) {
        
        $this->dealer_cards[] = $this->getCard();
        
      }
                  
      $dealer = $this->getDealerScore();
      $player = $this->getPlayerScore();
      
      if ($dealer > 21) {
        
        $this->status = 'player_win';
        
      } else if ($dealer == $player) {
        
        $this->status = 'push';
        
      } else if ($dealer > $player) {
        
        $this->status = 'dealer_win';
        
      } else {
        
        $this->status = 'player_win';
        
      }
      
    }
    
    function valueCards($cards) {
      
      $isBlackjack = true;
      
      foreach($cards as $card) {
        
        if ($card['rank'] != 'A') $isBlackjack = false;
        
      }
      
      if ($isBlackjack) return 21;
            
      $isHard = true;
      
      foreach($cards as $card) {
        
        if ($card['rank'] == 'A') $isHard = false;
        
      }
            
      $hardTotal = 0;
      $softTotal = 0;
      
      foreach($cards as $card) {
        
        $card = $card['rank'];
        
        if (is_numeric($card)) {
          
          $hardTotal += (int) $card;
          $softTotal += (int) $card;
          
        } else {
          
          $hardTotal += $card == 'A' ? 11 : 10;
          $softTotal += $card == 'A' ? 1 : 11;
                    
        }
                
      }
      
      return $hardTotal > 21 && !$isHard ? $softTotal : $hardTotal;
      
    }
        
  }
