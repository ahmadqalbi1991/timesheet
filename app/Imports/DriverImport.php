<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\User;

class DriverImport implements ToModel
{
    public function model(array $row)
    {
        // return new User([
        //     'name' => $row['Name'],
        //     'location' => $row['Location'],
        //     'coordinates_latitude' => $row['Cordinates Latitude'],
        //     'coordinates_longitude' => $row['Cordinates Longitude'],
        //     'first_mobile_number' => $row['First Mobile Number'],
        //     'second_mobile_number' => $row['Second Mobile Number'],
        //     'first_landline_number' => $row['First Landline Number'],
        //     'second_landline_number' => $row['Second Landline Number'],
        //     'first_email_address' => $row['First Email Address'],
        //     'second_email_address' => $row['Second Email Address'],
        //     'website_link' => $row['Website Link'],
        //     'capacity' => $row['Capacity'],
        //     'parking_space' => $row['Parking Space'],
        //     'gender' => $row['Gender'],
        //     'facilities' => $row['Facilities'],
        //     'services' => $row['Services'],
        //     'age_limit_for_sports' => $row['Age Limit For Sports'],
        //     'sports_list' => $row['Sports List'],
        //     'fitness' => $row['Fitness'],
        //     'academies' => $row['Academies'],
        //     'stadium_type' => $row['Stadium Type'],
        //     'active_fun' => $row['Active Fun'],
        //     'membership_plans' => $row['Membership Plans'],
        //     'opening_hours' => $row['Opening Hours'],
        //     'medical_facilities' => $row['MEDICAL FACILITIES'],
        //     'social_media_links' => $row['Social Media Links'],
        // ]);
    }
}
