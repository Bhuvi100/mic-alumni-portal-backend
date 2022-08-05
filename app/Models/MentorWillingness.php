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
        'ACS College of Engineering Karnataka Bangalore' => 'SW',
        'ANAND INSTITUTE OF HIGHER TECHNOLOGY Tamil Nadu CHENNAI' => 'SW',
        'Anurag Group of Institutions Telangana Hyderabad' => 'SW',
        'Birla Institute of Technology Mesra Ranchi Jharkhand Ranchi' => 'SW',
        'B. S. Abdur Rahman Crescent Institute of Science & Technology Tamil Nadu Chennai' => 'HW',
        'Cambridge Institute of Technology, K R Puram,Bangalore Karnataka Bangalore' => 'SW',
        'Chandigarh University Punjab Mohali' => 'SW',
        'Chitkara University Punjab Rajpura' => 'HW',
        'DR B C ROY ENGINEERING COLLEGE West Bengal DURGAPUR' => 'SW',
        'D. Y. Patil College of Engineering, Akurdi, Pune Maharashtra Pune' => 'SW',
        'Excel Engineering College Tamil Nadu Komarapalayam' => 'SW',
        'Forge Accelarator Tamil Nadu Coimbatore' => 'HW',
        'G H Raisoni College of Engineering, Nagpur Maharashtra Nagpur' => 'SW',
        'Galgotias University Uttar Pradesh Greater Noida' => 'HW',
        'GIET University Odisha Gunupur' => 'SW',
        'GMR Institute of Technology Andhra Pradesh Rajam' => 'SW',
        'Gujarat Technological University Gujarat Ahmedabad' => 'SW',
        'G.PULLAIAH COLLEGE OF ENGINEERING AND TECHNOLOGY Andhra Pradesh KURNOOL' => 'SW',
        'IES College of Technology Madhya Pradesh Bhopal' => 'SW',
        'IIT GUWAHATI Assam Guwahati' => 'SW',
        'IIT KANPUR Uttar Pradesh KANPUR' => 'SW',
        'Indian Institute of Technology Roorkee Uttarakhand Roorkee' => 'HW',
        'IT-BHU Uttar Pradesh BANARAS' => 'SW',
        'Jai Bharath College of Management and Engineering Technology Kerala Perumbavoor' => 'SW',
        'JAIN (Deemed-to-be University)Faculty of Engineering and Technology Karnataka Bengaluru' => 'HW',
        'JSS TECHNOLOGICAL UNIVERSITY Karnataka Mysore' => 'SW',
        'Kalasalingam Academy of Research and Education Tamil Nadu Srivilliputtur' => 'HW',
        'Karnavati University Gujarat Gandhinagar' => 'SW',
        'KIET Group of Institutions Ghaziabad Uttar Pradesh Ghaziabad' => 'HW',
        'KIT\'S College of Engineering Kolhapur Maharashtra Kolhapur' => 'SW',
        'KLE Technological University Karnataka Hubballi' => 'SW',
        'Koneru Lakshmaiah Education Foundation Andhra Pradesh Vijayawada' => 'SW',
        'Kongu Engineering College Tamil Nadu Erode' => 'SW',
        'Lovely Professional University Punjab Phagwara' => 'SW',
        'Malaviya National Institute of Technology Jaipur Rajasthan Jaipur' => 'SW',
        'Manav Rachna International Institute of Research and Studies Haryana Faridabad' => 'HW',
        'Manipal University Jaipur Rajasthan Jaipur' => 'HW',
        'MIT PUNE Maharashtra PUNE' => 'HW',
        'National Institute of Technology Silchar Assam Silchar' => 'SW',
        'Noida Institute of Engineering and Technology, Greater Noida Uttar Pradesh Greater Noida' => 'SW',
        'Paavai Engineering College Tamil Nadu Namakkal' => 'SW',
        'Parul University Gujarat Vadodara' => 'SW',
        'Presidency University, Bengaluru Karnataka Bengaluru' => 'SW',
        'Prin. L.N. Welingkar Institute of Management Development and Research (PGDM) Maharashtra Mumbai' => 'SW',
        'PSR ENGINEERING COLLEGE Tamil Nadu Sivakasi' => 'SW',
        'QIS COLLEGE OF ENGINEERING AND TECHNOLOGY Andhra Pradesh ONGOLE' => 'HW',
        'REVA University Karnataka Bengaluru' => 'HW',
        'SAGE University Indore Madhya Pradesh Indore' => 'SW',
        'Sahyadri College of Engineering & Management Karnataka Mangalore' => 'SW',
        'Sathyabama Institute of Science and Tehcnology Tamil Nadu Chennai' => 'SW',
        'SCMS School of Technology and Management Kerala Ernakulam' => 'SW',
        'Shri Ramdeobaba College of Engineering and Management, Nagpur Maharashtra Nagpur' => 'SW',
        'Sona College of Technology Tamil Nadu Salem' => 'SW',
        'SRI ESHWAR COLLEGE OF ENGINEERING Tamil Nadu COIMBATORE' => 'SW',
        'Sri Venkateswara College of Engineering and Technology Andhra Pradesh Chittoor' => 'SW',
        'SRM Institute of Science & Technology Tamil Nadu Chennai' => 'HW',
        'Techno International New Town West Bengal Kolkata' => 'SW',
        'Vaageswari College of Engineering Telangana Karimnagar' => 'SW',
        'VIGNANA BHARATHI INSTITUTE OF TECHNOLOGY Telangana HYDERABAD' => 'SW',
        'VNR VIGNANA JYOTHI INSTITUTE OF ENGINEERING & TECHNOLOGY Telangana HYDERABAD' => 'SW',
    ];
}
