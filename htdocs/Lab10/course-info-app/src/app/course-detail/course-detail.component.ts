import { Component , Input} from '@angular/core';
import { Course } from '../course';
import { FormsModule } from '@angular/forms';
import { NgIf } from '@angular/common';

@Component({
  selector: 'app-course-detail',
  standalone: true,
  imports: [FormsModule , NgIf],
  templateUrl: './course-detail.component.html',
  styleUrl: './course-detail.component.css'
})
export class CourseDetailComponent {
  @Input() course?: Course;
}
