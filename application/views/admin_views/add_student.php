<div id="content_area">
    <article>
        <h1>New Student Details</h1><br/>
        
        <table width="100%">
            <tr><td width="50%">
        <?php
        //print_r($options);
        echo form_open();
        
        echo form_label('User Name') . br();
        $data = array(
            'id' => 'username',
            'name' => 'username',
            'value' => set_value('username'),
            'style' => 'width:50%',
        );     
        echo form_input ($data) . br(2);
        echo form_error('username');  
        
        echo form_label('Password') . br();
        $data = array(
            'id' => 'password',
            'name' => 'password',
            'value' => set_value('password'),
            'style' => 'width:50%',
        );     
        echo form_input ($data) . br(2);
        echo form_error('password');  
        
        
        echo form_label('Student ID') . br();
        $data = array(
            'id' => 'student_id',
            'name' => 'student_id',
            'value' => set_value('student_id'),
            'style' => 'width:50%',
        );     
        echo form_input ($data) . br(2);
        echo form_error('student_id');
        
        echo form_label('First Name') . br();
        $data = array(
            'id' => 'first_name',
            'name' => 'first_name',
            'value' => set_value('first_name'),
            'style' => 'width:50%',
        );     
        echo form_input ($data) . br(2);
        echo form_error('first_name');  
        
        echo form_label('Last Name') . br();
        $data = array(
            'id' => 'last_name',
            'name' => 'last_name',
            'value' => set_value('last_name'),
            'style' => 'width:50%',
        );     
        echo form_input ($data) . br(2);
        echo form_error('last_name');        
 
        echo form_label('Course') . br();
        echo form_dropdown('course', $courses, '1') . br(2);    
        $data = array(
            'id' => 'course',
            'name' => 'course',
            'value' => set_value('course'),
            'style' => 'padding:10px; width:200px',
        );
        
        echo form_label('Stage of Course') . br();
        echo form_dropdown('stage', $stages, '1') . br(2);
        $data = array(
            'id' => 'stage',
            'name' => 'stage',
            'value' => set_value('stage'),
            'style' => 'padding:10px; width:200px',
        );
        ?>
                </td>
                <td width="50%">
        <?php
          
        echo form_label('Address Line 1') . br();
        $data = array(
            'id' => 'address_1',
            'name' => 'address_1',
            'value' => set_value('address_1'),
            'style' => 'width:50%',
        );     
        echo form_input ($data) . br(2);
        echo form_error('address_1');     
        
        echo form_label('Address Line 2') . br();
        $data = array(
            'id' => 'address_2',
            'name' => 'address_2',
            'value' => set_value('address_2'),
            'style' => 'width:50%',
        );     
        echo form_input ($data) . br(2);
        echo form_error('address_2');      
        
        echo form_label('Address Line 3') . br();
        $data = array(
            'id' => 'address_3',
            'name' => 'address_3',
            'value' => set_value('address_3'),
            'style' => 'width:50%',
        );     
        echo form_input ($data) . br(2);
        echo form_error('address_3');      
        
        echo form_label('Phone') . br();
        $data = array(
            'id' => 'phone',
            'name' => 'phone',
            'value' => set_value('phone'),
            'style' => 'width:50%',
        );     
        echo form_input ($data) . br(2);
        echo form_error('address_3');      
        
        
        
//        echo form_label('Semester') . br();
//        echo form_dropdown('semester', $semesters, '1') . br(2);
//        $data = array(
//            'id' => 'semester',
//            'name' => 'semester',
//            'value' => set_value('semester'),
//            'style' => 'padding:10px; width:200px',
//        );        
//      ----------------------------------
        
        $data = array(
            'id' => 'submit',
            'name' => 'submit',
            'value' => 'Add Student',
            'style' => 'padding:10px; width:200px',
        );
        echo form_submit($data);
        echo form_close();
        ?>
                </td>
            </tr>
        </table>
    </article>
</div>