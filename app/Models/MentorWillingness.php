<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorWillingness extends Model
{
    protected $table = 'mentor_willingness';

    protected $fillable = [
        'user_id',
        'hackathon',
        'interested',
        'category',
        'nodal_center',
        'associate',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static array $nodal_centers = [
        'A D Patel Institute of Technology Gujarat Anand' => 'HW',
        'Centurion University of Technology and Management Odisha Bhubaneswar' => 'HW',
        'Amal Jyothi College of Engineering Kerala Kanjirapally' => 'HW',
        'B. S. Abdur Rahman Crescent Institute of Science & Technology Tamil Nadu Chennai' => 'HW',
        'Bhilai Institute of Technology Chhattisgarh Durg' => 'HW',
        'Chitkara University Punjab Rajpura' => 'HW',
        'Forge Accelarator Tamil Nadu Coimbatore' => 'HW',
        'Galgotias University Uttar Pradesh Greater Noida' => 'HW',
        'Indian Institute of Technology Roorkee Uttarakhand Roorkee' => 'HW',
        'JAIN (Deemed-to-be University)Faculty of Engineering and Technology Karnataka Bengaluru' => 'HW',
        'Kalasalingam Academy of Research and Education Tamil Nadu Srivilliputtur' => 'HW',
        'KIET Group of Institutions Ghaziabad Uttar Pradesh Ghaziabad' => 'HW',
        'Manav Rachna International Institute of Research and Studies Haryana Faridabad' => 'HW',
        'Arya Institute of Engineering and Technology Rajasthan Jaipur' => 'HW',
        'MIT PUNE Maharashtra PUNE' => 'HW',
        'QIS COLLEGE OF ENGINEERING AND TECHNOLOGY Andhra Pradesh ONGOLE' => 'HW',
        'REVA University Karnataka Bengaluru' => 'HW',
        'SRM Institute of Science & Technology Tamil Nadu Chennai' => 'HW',



        'ACS College of Engineering Karnataka Bengaluru' => 'SW',
        'ANAND INSTITUTE OF HIGHER TECHNOLOGY Tamil Nadu CHENNAI' => 'SW',
        'Vardhaman College of Engineering Telangana Hyderabad' => 'SW',
        'Birla Institute of Technology Mesra Ranchi Jharkhand Ranchi' => 'SW',
        'Cambridge Institute of Technology, K R Puram,Bangalore Karnataka Bengaluru' => 'SW',
        'Siksha \'O\' Anusandhan Odisha Bhubaneswar' => 'SW',
        'Chandigarh University Punjab Mohali' => 'SW',
        'D. Y. Patil College of Engineering, Akurdi, Pune Maharashtra Pune' => 'SW',
        'DR B C ROY ENGINEERING COLLEGE West Bengal DURGAPUR' => 'SW',
        'Excel Engineering College Tamil Nadu Komarapalayam' => 'SW',
        'G H Raisoni College of Engineering, Nagpur Maharashtra Nagpur' => 'SW',
        'G.PULLAIAH COLLEGE OF ENGINEERING AND TECHNOLOGY Andhra Pradesh KURNOOL' => 'SW',
        'GIET University Odisha Gunupur' => 'SW',
        'GMR Institute of Technology Andhra Pradesh Rajam' => 'SW',
        'Gujarat Technological University Gujarat Ahmedabad' => 'SW',
        'Chandigarh Engineering college-CGC Punjab Landran,Mohali' => 'SW',
        'Hindusthan Institute of Technology, Coimbatore Tamil Nadu Coimbatore' => 'SW',
        'IES College of Technology Madhya Pradesh Bhopal' => 'SW',
        'IIT GUWAHATI Assam Guwahati' => 'SW',
        'IIT KANPUR Uttar Pradesh KANPUR' => 'SW',
        'IIT BHU Uttar Pradesh BANARAS' => 'SW',
        'Jai Bharath College of Management and Engineering Technology Kerala Perumbavoor' => 'SW',
        'JK Lakshmipat University Rajasthan Jaipur' => 'SW',
        'JSS TECHNOLOGICAL UNIVERSITY Karnataka Mysore' => 'SW',
        'Pandit Deendayal Energy University - PDEU Gujarat Gandhinagar' => 'SW',
        'KIT\'S College of Engineering Kolhapur Maharashtra Kolhapur' => 'SW',
        'KLE Technological University Karnataka Hubballi' => 'SW',
        'Koneru Lakshmaiah Education Foundation Andhra Pradesh Vijayawada' => 'SW',
        'Kongu Engineering College Tamil Nadu Erode' => 'SW',
        'KPR Institute of Engineering and Technology Tamil Nadu Coimbatore' => 'SW',
        'Lovely Professional University Punjab Phagwara' => 'SW',
        'Manipal University Jaipur Rajasthan Jaipur' => 'SW',
        'Maharastra Institute of Technology, (MIT Aurangabad) Maharashtra Aurangabad' => 'SW',
        'National Institute of Technology Silchar Assam Silchar' => 'SW',
        'Noida Institute of Engineering and Technology, Greater Noida Uttar Pradesh Greater Noida' => 'SW',
        'Paavai Engineering College Tamil Nadu Namakkal' => 'SW',
        'Parul University Gujarat Vadodara' => 'SW',
        'Presidency University, Bengaluru Karnataka Bengaluru' => 'SW',
        'Prin. L.N. Welingkar Institute of Management Development and Research (PGDM) Maharashtra Mumbai' => 'SW',
        'PSR ENGINEERING COLLEGE Tamil Nadu Sivakasi' => 'SW',
        'IIT (ISM) Dhanbad Jharkhand Dhanbad' => 'SW',
        'SAGE University Indore Madhya Pradesh Indore' => 'SW',
        'Sahyadri College of Engineering & Management Karnataka Mangalore' => 'SW',
        'Sathyabama Institute of Science and Tehcnology Tamil Nadu Chennai' => 'SW',
        'SCMS School of Technology and Management Kerala Ernakulam' => 'SW',
        'Shri Ramdeobaba College of Engineering and Management, Nagpur Maharashtra Nagpur' => 'SW',
        'Sikkim Manipal Institute of Technology Sikkim RANGPO' => 'SW',
        'Sona College of Technology Tamil Nadu Salem' => 'SW',
        'SRI ESHWAR COLLEGE OF ENGINEERING Tamil Nadu COIMBATORE' => 'SW',
        'Sri Shakthi Institute of Engineering & Technology Tamil Nadu Coimbatore' => 'SW',
        'Sri Venkateshwaraa College of Engineering and Technology Puducherry Puducherry' => 'SW',
        'Sri Venkateswara College of Engineering and Technology Andhra Pradesh Chittoor' => 'SW',
        'Talla Padmavathi College of Engineering Telangana Warangal' => 'SW',
        'Techno International New Town West Bengal Kolkata' => 'SW',
        'Vaageswari College of Engineering Telangana Karimnagar' => 'SW',
        'VIGNANA BHARATHI INSTITUTE OF TECHNOLOGY Telangana HYDERABAD' => 'SW',
        'VNR VIGNANA JYOTHI INSTITUTE OF ENGINEERING & TECHNOLOGY Telangana HYDERABAD' => 'SW',
    ];
}
