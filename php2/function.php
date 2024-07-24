<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Function</title>
</head>

<body>
    <h1>Berlatih Function PHP</h1>
    <?php

    echo "<h3> Soal No 1 Greetings </h3>";
    /* 
Soal No 1
Greetings
Buatlah sebuah function greetings() yang menerima satu parameter berupa string. 

contoh: greetings("abduh");
Output: "Halo Abduh, Selamat Datang di Sanbercode!"
*/

    // Code function di sini
    function greetings($nama)
    {
        echo "Halo $nama, Selamat Datang di Sanbercode!";
    }

    greetings("Bagas");
    echo "<br>";
    greetings("Wahyu");
    echo "<br>";
    greetings("Syahril");

    echo "<br>";

    echo "<h3>Soal No 2 Reverse String</h3>";
    /* 
Soal No 2
Reverse String
Buatlah sebuah function reverseString() untuk mengubah string berikut menjadi kebalikannya menggunakan function dan looping (for/while/do while).
Function reverseString menerima satu parameter berupa string.
NB: DILARANG menggunakan built-in function PHP sepert strrev(), HANYA gunakan LOOPING!

reverseString("abdul");
Output: ludba

*/

    // Code function di sini 
    function balikkata($kata1)
    {
        $panjangKata = strlen($kata1);
        $tampung = "";
        for ($i = $panjangKata - 1; $i >= 0; $i--) {
            $tampung .= $kata1[$i];
        }

        return $tampung;
    }

    function reverseString($katabalik)
    {
        $balikata = balikkata($katabalik);
        echo $balikata . "<br>";
    }
    reverseString("Syahril");
    reverseString("Sanbercode");
    reverseString("We Are Sanbers Developers");
    echo "<br>";

    echo "<h3>Soal No 3 Palindrome </h3>";
    /* 
Soal No 3 
Palindrome
Buatlah sebuah function yang menerima parameter berupa string yang mengecek apakah string tersebut sebuah palindrome atau bukan. 
Palindrome adalah sebuah kata atau kalimat yang jika dibalik akan memberikan kata yang sama contohnya: katak, civic.
Jika string tersebut palindrome maka akan mengembalikan nilai true, sedangkan jika bukan palindrome akan mengembalikan false.
NB: 
Contoh: 
palindrome("katak") => output : "true"
palindrome("jambu") => output : "false"
NB: DILARANG menggunakan built-in function PHP seperti strrev() dll. Gunakan looping seperti biasa atau gunakan function reverseString dari jawaban no.2!

*/


    // Code function di sini
    function palindrome($katapali)
    {
        $balikKata2 = balikkata($katapali);
        if ($balikKata2 === $katapali) {
            echo $katapali . "=> true <br>";
        } else {
            echo $katapali . "=> false <br>";
        }
    }
    palindrome("civic"); // true
    palindrome("nababan"); // true
    palindrome("jambaban"); // false
    palindrome("racecar"); // true


    echo "<h3>Soal No 4 Tentukan Nilai </h3>";
    /*
Soal 4
buatlah sebuah function bernama tentukan_nilai . Di dalam function tentukan_nilai yang menerima parameter 
berupa integer. dengan ketentuan jika paramater integer lebih besar dari sama dengan 85 dan lebih kecil sama dengan 100 maka akan mereturn String “Sangat Baik” 
Selain itu jika parameter integer lebih besar sama dengan 70 dan lebih kecil dari 85 maka akan mereturn string “Baik” selain itu jika parameter number lebih besar 
sama dengan 60 dan lebih kecil dari 70 maka akan mereturn string “Cukup” selain itu maka akan mereturn string “Kurang”
*/

    // Code function di sini

    function tentukan_nilai($nilai)
    {
        if ($nilai >= 85 && $nilai <= 100) {
            return $nilai . " => Sangat Baik <br>";
        } else if ($nilai < 85 && $nilai >= 70) {
            return $nilai . " => Baik <br>";
        } else if ($nilai < 70 && $nilai >= 50) {
            return $nilai . " => Cukup <br>";
        } else if ($nilai < 50 && $nilai >= 30) {
            return $nilai . " => Kurang <br>";
        } else {
            return $nilai . " => Nilai Kosong! <br>";
        }
    }
    // Hapus komentar di bawah ini untuk jalankan code
    echo tentukan_nilai(98); //Sangat Baik
    echo tentukan_nilai(76); //Baik
    echo tentukan_nilai(67); //Cukup
    echo tentukan_nilai(43); //Kurang
    ?>

</body>

</html>