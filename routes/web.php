<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//登录路由
Route::get('/login', 'Admin\LoginController@getLogin')->name('login');
Route::post('/getlogin', 'Admin\LoginController@getLogin');

//管理员管理路由组
Route::group(['namespace'=>'Admin','middleware'=>'islogin'],function(){
	/*主页路由*/
	 Route::get('/index', 'IndexController@index');
	 Route::get('/welcome','IndexController@welcome');
	 /*首页路由*/
	 Route::get('/logout', 'LoginController@logout');
	 /*学校领导管理路由*/
	 Route::get('/user', 'UserController@userList');
	 Route::get('/userAdd', 'UserController@userAdd');
	 Route::post('/userFind', 'UserController@userFind');
	 Route::get('/userEdit', 'UserController@userEdit')->name('userEdit');
	 Route::get('/userDelete', 'UserController@userDelete')->name('userDelete');
	 Route::post('/userA', 'UserController@userAdd');
	 Route::post('/userE', 'UserController@userEdit');
	 /*学生管理路由*/
	 Route::get('/student', 'StudentController@studentList');
	 Route::get('/studentAdd', 'StudentController@studentAdd');
	 Route::post('/studentFind', 'StudentController@studentFind');
	 Route::get('/studentEdit', 'StudentController@studentEdit')->name('studentEdit');
	 Route::get('/studentDelete', 'StudentController@studentDelete')->name('studentDelete');
	 Route::post('/studentA', 'StudentController@studentAdd');
	 Route::post('/studentE', 'StudentController@studentEdit');
	 /*教师管理路由*/
	 Route::get('/teacher', 'TeacherController@teacherList');
	 Route::get('/teacherAdd', 'TeacherController@teacherAdd');
	 Route::post('/teacherFind', 'TeacherController@teacherFind');
	 Route::get('/teacherEdit', 'TeacherController@teacherEdit')->name('teacherEdit');
	 Route::get('/teacherDelete', 'TeacherController@teacherDelete')->name('teacherDelete');
	 Route::post('/teacherA', 'TeacherController@teacherAdd');
	 Route::post('/teacherE', 'TeacherController@teacherEdit');
	 /*科目管理路由*/
	 Route::get('/subject', 'SubjectController@subjectList');
	 Route::get('/subjectAdd', 'SubjectController@subjectAdd');
	 Route::get('/subjectEdit', 'SubjectController@subjectEdit')->name('subjectEdit');
	 Route::get('/subjectDelete', 'SubjectController@subjectDelete')->name('subjectDelete');
	 Route::post('/subjectA', 'SubjectController@subjectAdd');
	 Route::post('/subjectFind', 'SubjectController@subjectFind');
	 Route::post('/subjectE', 'SubjectController@subjectEdit');
	 /*成绩管理路由*/
	 Route::get('/exam', 'ExamController@examList');
	 Route::get('/examAdd', 'ExamController@examAdd');
	 Route::get('/examEdit', 'ExamController@examEdit')->name('examEdit');
	 Route::get('/examDelete', 'ExamController@examDelete')->name('examDelete');
	 Route::post('/examA', 'ExamController@examAdd');
	 Route::post('/examFind', 'ExamController@examFind');
	 Route::post('/examE', 'ExamController@examEdit');
	 /*评教指标管理路由*/
	 Route::get('/comment', 'CommentController@commentList');
	 Route::get('/commentAdd', 'CommentController@commentAdd');
	 Route::get('/commentE', 'CommentController@commentE')->name('commentE');
	 Route::get('/commentDelete', 'CommentController@commentDelete')->name('commentDelete');
	 Route::post('/commentA', 'CommentController@commentAdd');
	 Route::post('/commentE', 'CommentController@commentE');
	 /*评教管理路由*/
	 Route::get('/teach', 'TeachController@teachList');
	 Route::get('/commentEdit', 'TeachController@commentEdit')->name('commentEdit');
	 Route::post('/teachA', 'TeachController@commentEdit');
	 Route::post('/teach', 'TeachController@teachList');
	 Route::get('/teachDelete', 'TeachController@teachDelete')->name('teachDelete');
	 /*部门管理路由*/
	 Route::get('/department','DepartmentController@departmentList');
	 Route::post('/departmentFind','DepartmentController@departmentFind');
	 Route::get('/departmentAdd','DepartmentController@departmentAdd')->name('departmentAdd');
	 Route::post('/departmentA','DepartmentController@departmentAdd');
	 Route::get('/departmentEdit','DepartmentController@departmentEdit')->name('departmentEdit');
	 Route::get('/departmentDelete','DepartmentController@departmentDelete')->name('departmentDelete');
	 Route::post('/departmentE','DepartmentController@departmentEdit');
});

//学生个人管理路由组
Route::group(['namespace'=>'Student','middleware'=>'islogin'],function(){
	/*学生个人信息列表路由*/
	 Route::get('/student/xinxi','StudentController@studentList');
	 Route::post('/student/studentE', 'StudentController@studentEdit');
	/*学生个人信息修改路由*/
	 Route::get('/student/studentEdit', 'StudentController@studentEdit')->name('student/studentEdit');
	/*学生个人成绩列表路由*/
	 Route::get('/student/studentExamList','StudentController@studentExamList');
	/*学生个人课表列表路由*/
	 Route::get('/student/studentSubjectList','StudentController@studentSubjectList');
	/*学生个人成绩按学期查询路由*/
	 Route::get('/student/studentChooseYear','StudentController@studentChooseYear');
	/*学生个人成绩按科目查询路由*/
	 Route::get('/student/studentChooseSubject','StudentController@studentChooseSubject');
	 /*学生教评列表中间路由*/
	 Route::get('/student/studentTeachList', 'StudentController@studentTeachList');
	 Route::post('/student/studentTeachList', 'StudentController@studentTeachList');
	 /*学生评教页面路由*/
	 Route::get('/student/studentTeachList16171', 'StudentController@studentTeachLists');
	 Route::get('/student/studentTeachList16172', 'StudentController@studentTeachListes');
	 Route::get('/student/studentTeachList17181', 'StudentController@studentTeachListss');
	 Route::get('/student/studentTeachList17182', 'StudentController@studentTeachListess');
	 Route::get('/student/studentTeachList18191', 'StudentController@studentTeachListsss');
	 Route::get('/student/studentTeachList18192', 'StudentController@studentTeachListesss');
	 Route::get('/student/studentTeachList19201', 'StudentController@studentTeachListssss');
	 Route::get('/student/studentTeachList19202', 'StudentController@studentTeachListessss');
	 /*学生教评判断路由*/
	 Route::get('/student/studentTeachA', 'StudentController@studentTeachA')->name('student/studentTeachA');
	 /*学生教评路由*/
	 Route::post('/student/studentTeach', 'StudentController@studentTeach')->name('student/studentTeach');
});

//教师个人管理路由组
Route::group(['namespace'=>'Teacher','middleware'=>'islogin'],function(){
	/*教师个人信息列表路由*/
	 Route::get('/teacher/xinxi','TeacherController@teacherList');
	 Route::post('/teacher/teacherE', 'TeacherController@teacherEdit');
	/*教师个人信息修改路由*/
	 Route::get('/teacher/teacherEdit', 'TeacherController@teacherEdit')->name('teacher/teacherEdit');
	/*教师教学科目列表路由*/
	 Route::get('/teacher/teacherSubjectList', 'TeacherController@teacherSubjectList');
	/*教师学生成绩列表管理路由*/
	 Route::get('/teacher/studentExamList', 'TeacherController@studentExamList');
	/*教师修改学生成绩路由*/
	 Route::get('/teacher/studentexamE','TeacherController@studentexamE')->name('teacher/studentexamE');
	 Route::post('/teacher/studentexamE','TeacherController@studentexamE');
	/*教师添加学生成绩路由*/
	 Route::get('/teacher/studentexamA', 'TeacherController@studentexamA');
	 Route::post('/teacher/studentexamA', 'TeacherController@studentexamA');
	 /*教师删除学生成绩路由*/
	 Route::get('/teacher/examDelete', 'TeacherController@examDelete')->name('teacher/examDelete');
	/*教师评教列表中间路由*/
	 Route::get('/teacher/teacherTeachList', 'TeacherController@teacherTeachList');
	 Route::post('/teacher/teacherTeachList', 'TeacherController@teacherTeachList');
	  /*教师评教页面路由*/
	 Route::get('/teacher/teacherTeachList16171', 'TeacherController@teacherTeachLists');
	 Route::get('/teacher/teacherTeachList16172', 'TeacherController@teacherTeachListes');
	 Route::get('/teacher/teacherTeachList17181', 'TeacherController@teacherTeachListss');
	 Route::get('/teacher/teacherTeachList17182', 'TeacherController@teacherTeachListess');
	 Route::get('/teacher/teacherTeachList18191', 'TeacherController@teacherTeachListsss');
	 Route::get('/teacher/teacherTeachList18192', 'TeacherController@teacherTeachListesss');
	 Route::get('/teacher/teacherTeachList19201', 'TeacherController@teacherTeachListssss');
	 Route::get('/teacher/teacherTeachList19202', 'TeacherController@teacherTeachListessss');
	 /*教师评教判断路由*/
	 Route::get('/teacher/teacherTeachA', 'TeacherController@teacherTeachA')->name('teacher/teacherTeachA');
	 /*教师评教路由*/
	 Route::post('/teacher/teacherTeach', 'TeacherController@teacherTeach')->name('teacher/teacherTeach');
	  /*教师学生教评结果查看路由*/
	 Route::get('/teacher/teacherTeachL', 'TeacherController@teacherTeachL');
	 /*教师同行教评结果查看路由*/
	 Route::get('/teacher/teacherTeachLs', 'TeacherController@teacherTeachLs');
	 /*教师领导教评结果查看路由*/
	 Route::get('/teacher/teacherTeachLss', 'TeacherController@teacherTeachLss');
});

//学校领导个人管理路由组
Route::group(['namespace'=>'User','middleware'=>'islogin'],function(){
	/*学校领导个人信息列表路由*/
	Route::get('/user/xinxi','UserController@userList');
	Route::post('/user/userE', 'UserController@userEdit');
	/*学校领导个人信息修改路由*/
	Route::get('/user/userEdit', 'UserController@userEdit')->name('user/userEdit');
	/*学校领导评教列表中间路由*/
	 Route::get('/user/userTeachList', 'UserController@userTeachList');
	 Route::post('/user/userTeachList', 'UserController@userTeachList');
	  /*学校领导评教页面路由*/
	 Route::get('/user/userTeachList16171', 'UserController@userTeachLists');
	 Route::get('/user/userTeachList16172', 'UserController@userTeachListes');
	 Route::get('/user/userTeachList17181', 'UserController@userTeachListss');
	 Route::get('/user/userTeachList17182', 'UserController@userTeachListess');
	 Route::get('/user/userTeachList18191', 'UserController@userTeachListsss');
	 Route::get('/user/userTeachList18192', 'UserController@userTeachListesss');
	 Route::get('/user/userTeachList19201', 'UserController@userTeachListssss');
	 Route::get('/user/userTeachList19202', 'UserController@userTeachListessss');
	  /*学校领导评教判断路由*/
	 Route::get('/user/userTeachA', 'UserController@userTeachA')->name('user/userTeachA');
	 /*学校领导评教路由*/
	 Route::post('/user/userTeach', 'UserController@userTeach')->name('user/userTeach');
});