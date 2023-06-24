<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::truncate();

        $data = [
            [
                'name' => 'Afghanistan',
                'status' => 1,
            ],
            [
                'name' => 'Albania',
                'status' => 1,
            ],
            [
                'name' => 'Algeria',
                'status' => 1,
            ],
            [
                'name' => 'Andorra',
                'status' => 1,
            ],
            [
                'name' => 'Angola',
                'status' => 1,
            ],
            [
                'name' => 'Antigua and Barbuda',
                'status' => 1,
            ],
            [
                'name' => 'Argentina',
                'status' => 1,
            ],
            [
                'name' => 'Armenia',
                'status' => 1,
            ],
            [
                'name' => 'Australia',
                'status' => 1,
            ],
            [
                'name' => 'Austria',
                'status' => 1,
            ],
            [
                'name' => 'Azerbaijan',
                'status' => 1,
            ],
            [
                'name' => 'Bahamas',
                'status' => 1,
            ],
            [
                'name' => 'Bahrain',
                'status' => 1,
            ],
            [
                'name' => 'Bangladesh',
                'status' => 1,
            ],
            [
                'name' => 'Barbados',
                'status' => 1,
            ],
            [
                'name' => 'Belarus',
                'status' => 1,
            ],
            [
                'name' => 'Belgium',
                'status' => 1,
            ],
            [
                'name' => 'Belize',
                'status' => 1,
            ],
            [
                'name' => 'Benin',
                'status' => 1,
            ],
            [
                'name' => 'Bhutan',
                'status' => 1,
            ],
            [
                'name' => 'Bolivia',
                'status' => 1,
            ],
            [
                'name' => 'Bosnia and Herzegovina',
                'status' => 1,
            ],
            [
                'name' => 'Botswana',
                'status' => 1,
            ],
            [
                'name' => 'Brazil',
                'status' => 1,
            ],
            [
                'name' => 'Brunei',
                'status' => 1,
            ],
            [
                'name' => 'Bulgaria',
                'status' => 1,
            ],
            [
                'name' => 'Burkina Faso',
                'status' => 1,
            ],
            [
                'name' => 'Burundi',
                'status' => 1,
            ],
            [
                'name' => 'Cambodia',
                'status' => 1,
            ],
            [
                'name' => 'Cameroon',
                'status' => 1,
            ],
            [
                'name' => 'Canada',
                'status' => 1,
            ],
            [
                'name' => 'Cape Verde',
                'status' => 1,
            ],
            [
                'name' => 'Central African Republic',
                'status' => 1,
            ],
            [
                'name' => 'Chad',
                'status' => 1,
            ],
            [
                'name' => 'Chile',
                'status' => 1,
            ],
            [
                'name' => 'China',
                'status' => 1,
            ],
            [
                'name' => 'Colombi',
                'status' => 1,
            ],
            [
                'name' => 'Comoros',
                'status' => 1,
            ],
            [
                'name' => 'Congo (Brazzaville)',
                'status' => 1,
            ],
            [
                'name' => 'Congo',
                'status' => 1,
            ],
            [
                'name' => 'Costa Rica',
                'status' => 1,
            ],
            [
                'name' => 'Cote d\'Ivoire',
                'status' => 1,
            ],
            [
                'name' => 'Croatia',
                'status' => 1,
            ],
            [
                'name' => 'Cuba',
                'status' => 1,
            ],
            [
                'name' => 'Cyprus',
                'status' => 1,
            ],
            [
                'name' => 'Czech Republic',
                'status' => 1,
            ],
            [
                'name' => 'Denmark',
                'status' => 1,
            ],
            [
                'name' => 'Djibouti',
                'status' => 1,
            ],
            [
                'name' => 'Dominica',
                'status' => 1,
            ],
            [
                'name' => 'Dominican Republic',
                'status' => 1,
            ],
            [
                'name' => 'East Timor (Timor Timur)',
                'status' => 1,
            ],
            [
                'name' => 'Ecuador',
                'status' => 1,
            ],
            [
                'name' => 'Egypt',
                'status' => 1,
            ],
            [
                'name' => 'El Salvador',
                'status' => 1,
            ],
            [
                'name' => 'Equatorial Guinea',
                'status' => 1,
            ],
            [
                'name' => 'Eritrea',
                'status' => 1,
            ],
            [
                'name' => 'Estonia',
                'status' => 1,
            ],
            [
                'name' => 'Ethiopia',
                'status' => 1,
            ],
            [
                'name' => 'Fiji',
                'status' => 1,
            ],
            [
                'name' => 'Finland',
                'status' => 1,
            ],
            [
                'name' => 'France',
                'status' => 1,
            ],
            [
                'name' => 'Gabon',
                'status' => 1,
            ],
            [
                'name' => 'Gambia, The',
                'status' => 1,
            ],
            [
                'name' => 'Georgia',
                'status' => 1,
            ],
            [
                'name' => 'Germany',
                'status' => 1,
            ],
            [
                'name' => 'Ghana',
                'status' => 1,
            ],
            [
                'name' => 'Greece',
                'status' => 1,
            ],
            [
                'name' => 'Grenada',
                'status' => 1,
            ],
            [
                'name' => 'Guatemala',
                'status' => 1,
            ],
            [
                'name' => 'Guinea',
                'status' => 1,
            ],
            [
                'name' => 'Guinea-Bissau',
                'status' => 1,
            ],
            [
                'name' => 'Guyana',
                'status' => 1,
            ],
            [
                'name' => 'Haiti',
                'status' => 1,
            ],
            [
                'name' => 'Honduras',
                'status' => 1,
            ],
            [
                'name' => 'Hungary',
                'status' => 1,
            ],
            [
                'name' => 'Iceland',
                'status' => 1,
            ],
            [
                'name' => 'India',
                'status' => 1,
            ],
            [
                'name' => 'Indonesia',
                'status' => 1,
            ],
            [
                'name' => 'Iran',
                'status' => 1,
            ],
            [
                'name' => 'Iraq',
                'status' => 1,
            ],
            [
                'name' => 'Ireland',
                'status' => 1,
            ],
            [
                'name' => 'Israel',
                'status' => 1,
            ],
            [
                'name' => 'Italy',
                'status' => 1,
            ],
            [
                'name' => 'Jamaica',
                'status' => 1,
            ],
            [
                'name' => 'Japan',
                'status' => 1,
            ],
            [
                'name' => 'Jordan',
                'status' => 1,
            ],
            [
                'name' => 'Kazakhstan',
                'status' => 1,
            ],
            [
                'name' => 'Kenya',
                'status' => 1,
            ],
            [
                'name' => 'Kiribati',
                'status' => 1,
            ],
            [
                'name' => 'Korea, North',
                'status' => 1,
            ],
            [
                'name' => 'Korea, South',
                'status' => 1,
            ],
            [
                'name' => 'Kuwait',
                'status' => 1,
            ],
            [
                'name' => 'Kyrgyzstan',
                'status' => 1,
            ],
            [
                'name' => 'Laos',
                'status' => 1,
            ],
            [
                'name' => 'Latvia',
                'status' => 1,
            ],
            [
                'name' => 'Lebanon',
                'status' => 1,
            ],
            [
                'name' => 'Lesotho',
                'status' => 1,
            ],
            [
                'name' => 'Liberia',
                'status' => 1,
            ],
            [
                'name' => 'Libya',
                'status' => 1,
            ],
            [
                'name' => 'Liechtenstein',
                'status' => 1,
            ],
            [
                'name' => 'Lithuania',
                'status' => 1,
            ],
            [
                'name' => 'Luxembourg',
                'status' => 1,
            ],
            [
                'name' => 'Macedonia',
                'status' => 1,
            ],
            [
                'name' => 'Madagascar',
                'status' => 1,
            ],
            [
                'name' => 'Malawi',
                'status' => 1,
            ],
            [
                'name' => 'Malaysia',
                'status' => 1,
            ],
            [
                'name' => 'Maldives',
                'status' => 1,
            ],
            [
                'name' => 'Mali',
                'status' => 1,
            ],
            [
                'name' => 'Malta',
                'status' => 1,
            ],
            [
                'name' => 'Marshall Islands',
                'status' => 1,
            ],
            [
                'name' => 'Mauritania',
                'status' => 1,
            ],
            [
                'name' => 'Mauritius',
                'status' => 1,
            ],
            [
                'name' => 'Mexico',
                'status' => 1,
            ],
            [
                'name' => 'Micronesia',
                'status' => 1,
            ],
            [
                'name' => 'Moldova',
                'status' => 1,
            ],
            [
                'name' => 'Monaco',
                'status' => 1,
            ],
            [
                'name' => 'Mongolia',
                'status' => 1,
            ],
            [
                'name' => 'Morocco',
                'status' => 1,
            ],
            [
                'name' => 'Mozambique',
                'status' => 1,
            ],
            [
                'name' => 'Myanmar',
                'status' => 1,
            ],
            [
                'name' => 'Namibia',
                'status' => 1,
            ],
            [
                'name' => 'Nauru',
                'status' => 1,
            ],
            [
                'name' => 'Nepal',
                'status' => 1,
            ],
            [
                'name' => 'Netherlands',
                'status' => 1,
            ],
            [
                'name' => 'New Zealand',
                'status' => 1,
            ],
            [
                'name' => 'Nicaragua',
                'status' => 1,
            ],
            [
                'name' => 'Niger',
                'status' => 1,
            ],
            [
                'name' => 'Nigeria',
                'status' => 1,
            ],
            [
                'name' => 'Norway',
                'status' => 1,
            ],
            [
                'name' => 'Oman',
                'status' => 1,
            ],
            [
                'name' => 'Pakistan',
                'status' => 1,
            ],
            [
                'name' => 'Palau',
                'status' => 1,
            ],
            [
                'name' => 'Panama',
                'status' => 1,
            ],
            [
                'name' => 'Papua New Guinea',
                'status' => 1,
            ],
            [
                'name' => 'Paraguay',
                'status' => 1,
            ],
            [
                'name' => 'Peru',
                'status' => 1,
            ],
            [
                'name' => 'Philippines',
                'status' => 1,
            ],
            [
                'name' => 'Poland',
                'status' => 1,
            ],
            [
                'name' => 'Portugal',
                'status' => 1,
            ],
            [
                'name' => 'Qatar',
                'status' => 1,
            ],
            [
                'name' => 'Romania',
                'status' => 1,
            ],
            [
                'name' => 'Russia',
                'status' => 1,
            ],
            [
                'name' => 'Rwanda',
                'status' => 1,
            ],
            [
                'name' => 'Saint Kitts and Nevis',
                'status' => 1,
            ],
            [
                'name' => 'Saint Lucia',
                'status' => 1,
            ],
            [
                'name' => 'Saint Vincent',
                'status' => 1,
            ],
            [
                'name' => 'Samoa',
                'status' => 1,
            ],
            [
                'name' => 'San Marino',
                'status' => 1,
            ],
            [
                'name' => 'Sao Tome and Principe',
                'status' => 1,
            ],
            [
                'name' => 'Saudi Arabia',
                'status' => 1,
            ],
            [
                'name' => 'Senegal',
                'status' => 1,
            ],
            [
                'name' => 'Serbia and Montenegro',
                'status' => 1,
            ],
            [
                'name' => 'Seychelles',
                'status' => 1,
            ],
            [
                'name' => 'Sierra Leone',
                'status' => 1,
            ],
            [
                'name' => 'Singapore',
                'status' => 1,
            ],
            [
                'name' => 'Slovakia',
                'status' => 1,
            ],
            [
                'name' => 'Slovenia',
                'status' => 1,
            ],
            [
                'name' => 'Solomon Islands',
                'status' => 1,
            ],
            [
                'name' => 'Somalia',
                'status' => 1,
            ],
            [
                'name' => 'South Africa',
                'status' => 1,
            ],
            [
                'name' => 'Spain',
                'status' => 1,
            ],
            [
                'name' => 'Sri Lanka',
                'status' => 1,
            ],
            [
                'name' => 'Sudan',
                'status' => 1,
            ],
            [
                'name' => 'Suriname',
                'status' => 1,
            ],
            [
                'name' => 'Swaziland',
                'status' => 1,
            ],
            [
                'name' => 'Sweden',
                'status' => 1,
            ],
            [
                'name' => 'Switzerland',
                'status' => 1,
            ],
            [
                'name' => 'Syria',
                'status' => 1,
            ],
            [
                'name' => 'Taiwan',
                'status' => 1,
            ],
            [
                'name' => 'Tajikistan',
                'status' => 1,
            ],
            [
                'name' => 'Tanzania',
                'status' => 1,
            ],
            [
                'name' => 'Thailand',
                'status' => 1,
            ],
            [
                'name' => 'Togo',
                'status' => 1,
            ],
            [
                'name' => 'Tonga',
                'status' => 1,
            ],
            [
                'name' => 'Trinidad and Tobago',
                'status' => 1,
            ],
            [
                'name' => 'Tunisia',
                'status' => 1,
            ],
            [
                'name' => 'Turkey',
                'status' => 1,
            ],
            [
                'name' => 'Turkmenistan',
                'status' => 1,
            ],
            [
                'name' => 'Tuvalu',
                'status' => 1,
            ],
            [
                'name' => 'Uganda',
                'status' => 1,
            ],
            [
                'name' => 'Ukraine',
                'status' => 1,
            ],
            [
                'name' => 'United Arab Emirates',
                'status' => 1,
            ],
            [
                'name' => 'United Kingdom',
                'status' => 1,
            ],
            [
                'name' => 'United States',
                'status' => 1,
            ],
            [
                'name' => 'Uruguay',
                'status' => 1,
            ],
            [
                'name' => 'Uzbekistan',
                'status' => 1,
            ],
            [
                'name' => 'Vanuatu',
                'status' => 1,
            ],
            [
                'name' => 'Vatican City',
                'status' => 1,
            ],
            [
                'name' => 'Venezuela',
                'status' => 1,
            ],
            [
                'name' => 'Vietnam',
                'status' => 1,
            ],
            [
                'name' => 'Yemen',
                'status' => 1,
            ],
            [
                'name' => 'Zambia',
                'status' => 1,
            ],
            [
                'name' => 'Zimbabwe',
                'status' => 1,
            ]
        ];

        foreach ($data as $item) {
            Country::create($item);
        }
    }
}
