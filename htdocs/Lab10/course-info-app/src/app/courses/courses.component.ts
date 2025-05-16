import { Component } from '@angular/core';
import { Course } from '../course';
import { FormsModule } from '@angular/forms';
import { COURSES } from '../test-course';
import { NgFor ,NgIf } from '@angular/common';
import { CourseDetailComponent } from '../course-detail/course-detail.component';
@Component({
  selector: 'app-courses',
  standalone: true,
  imports: [FormsModule, NgFor, CourseDetailComponent],
  templateUrl: './courses.component.html',
  styleUrls: ['./courses.component.css']
})
export class CoursesComponent {
  //Task1
  // course: Course = {
  //   course_id: 1,
  //   course_title: 'Web Development',
  //   semester: 'One',
  //   period: 'Wednesday 4-6pm',
  //   lecturer: 'Dr. Jian Yu'
  // };
  //Task2
  // course: Course = COURSES[0];
  // courses = COURSES;
  courses = COURSES;
  selectedCourse?: Course;

  onSelect(course: Course): void {
    this.selectedCourse = course;
  }
}
