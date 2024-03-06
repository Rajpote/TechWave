<?php

function displayRating($conn, $gadgetID)
{
    $averageRating = calculateAverageRating($conn, $gadgetID);
    $averageRatingFormatted = number_format($averageRating, 1);

    $fullStars = floor($averageRatingFormatted);
    $hasHalfStar = $averageRatingFormatted - $fullStars >= 0.25;

    for ($i = 1; $i <= $fullStars; $i++) {
        echo '<i class="fa-solid fa-star" style="color:gold;"></i>'; // Full star
    }

    if ($hasHalfStar) {
        echo '<i class="fa-solid fa-star-half-stroke" style="color:gold;"></i>'; // Half star
    }

    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);

    for ($i = 1; $i <= $emptyStars; $i++) {
        echo '<i class="fa-regular fa-star" style="color:gold;"></i>'; // Empty star
    }

    echo " $averageRatingFormatted";
}

function calculateAverageRating($conn, $gadgetID)
{
    $query = "SELECT AVG(rating) AS average_rating FROM feedback WHERE g_id = :gadgetID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':gadgetID', $gadgetID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($result['average_rating']) ? $result['average_rating'] : 0;
}
