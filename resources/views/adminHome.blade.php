@extends('layouts.app')

@section('content')
<div class="card-container">
    <a href="{{ route('projects.index') }}" class="card-link">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Total Projects</h3>
                <p class="card-number">{{ $totalProjects }}</p>
            </div>
        </div>
    </a>

    <a href="{{ route('customers.index') }}" class="card-link">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Total Customers</h3>
                <p class="card-number">{{ $totalCustomers }}</p>
            </div>
        </div>
    </a>

    <a href="{{ route('products.index') }}" class="card-link">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Total Services</h3>
                <p class="card-number">{{ $totalServices }}</p>
            </div>
        </div>
    </a>

    <a href="{{ route('users.index') }}" class="card-link">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Total Users</h3>
                <p class="card-number">{{ $totalUsers }}</p>
            </div>
        </div>
    </a>
</div>

<div class="wrapper">
    <div class="task-section">
        <div class="task-input">
            <img src="{{ asset('images/bars.png') }}" alt="icon">
            <input type="text" placeholder="Add a new task">
        </div>
        <div class="controls">
            <div class="filters">
                <span class="active" id="all">All</span>
                <span id="pending">Pending</span>
                <span id="completed">Completed</span>
            </div>
            <button class="clear-btn">Clear All</button>
        </div>
        <ul class="task-box"></ul>
    </div>
</div>
    <div class="calendar-section">
        <div class="calendar">
            <!-- Calendar HTML goes here -->
            <div class="calendar-header">
                <span class="month-picker" id="month-picker"> May </span>
                <div class="year-picker" id="year-picker">
                    <span class="year-change" id="pre-year">
                        <pre><</pre>
                    </span>
                    <span id="year">2020 </span>
                    <span class="year-change" id="next-year">
                        <pre>></pre>
                    </span>
                </div>
            </div>
            <div class="calendar-body">
                <div class="calendar-week-days">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>
                <div class="calendar-days"></div>
            </div>
            <div class="calendar-footer"></div>
            <div class="date-time-formate">
                <div class="day-text-formate">TODAY</div>
                <div class="date-time-value">
                    <div class="time-formate">01:41:20</div>
                    <div class="date-formate">03 - march - 2022</div>
                </div>
            </div>
            <div class="month-list"></div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    const taskInput = document.querySelector(".task-input input"),
    filters = document.querySelectorAll(".filters span"),
    clearAll = document.querySelector(".clear-btn"),
    taskBox = document.querySelector(".task-box");
    let editId,
    isEditTask = false,
    todos = JSON.parse(localStorage.getItem("todo-list"));
    filters.forEach(btn => {
        btn.addEventListener("click", () => {
            document.querySelector("span.active").classList.remove("active");
            btn.classList.add("active");
            showTodo(btn.id);
        });
    });
    function showTodo(filter) {
        let liTag = "";
        if(todos) {
            todos.forEach((todo, id) => {
                let completed = todo.status == "completed" ? "checked" : "";
                if(filter == todo.status || filter == "all") {
                    liTag += `<li class="task">
                                <label for="${id}">
                                    <input onclick="updateStatus(this)" type="checkbox" id="${id}" ${completed}>
                                    <p class="${completed}">${todo.name}</p>
                                </label>
                                <div class="settings">
                                    <i onclick="showMenu(this)" class="uil uil-ellipsis-h"></i>
                                    <ul class="task-menu">
                                        <li onclick='editTask(${id}, "${todo.name}")'><i class="uil uil-pen"></i>Edit</li>
                                        <li onclick='deleteTask(${id}, "${filter}")'><i class="uil uil-trash"></i>Delete</li>
                                    </ul>
                                </div>
                            </li>`;
                }
            });
        }
        taskBox.innerHTML = liTag || `<span>You don't have any task here</span>`;
        let checkTask = taskBox.querySelectorAll(".task");
        !checkTask.length ? clearAll.classList.remove("active") : clearAll.classList.add("active");
        taskBox.offsetHeight >= 300 ? taskBox.classList.add("overflow") : taskBox.classList.remove("overflow");
    }
    showTodo("all");
    function showMenu(selectedTask) {
        let menuDiv = selectedTask.parentElement.lastElementChild;
        menuDiv.classList.add("show");
        document.addEventListener("click", e => {
            if(e.target.tagName != "I" || e.target != selectedTask) {
                menuDiv.classList.remove("show");
            }
        });
    }
    function updateStatus(selectedTask) {
        let taskName = selectedTask.parentElement.lastElementChild;
        if(selectedTask.checked) {
            taskName.classList.add("checked");
            todos[selectedTask.id].status = "completed";
        } else {
            taskName.classList.remove("checked");
            todos[selectedTask.id].status = "pending";
        }
        localStorage.setItem("todo-list", JSON.stringify(todos))
    }
    function editTask(taskId, textName) {
        editId = taskId;
        isEditTask = true;
        taskInput.value = textName;
        taskInput.focus();
        taskInput.classList.add("active");
    }
    function deleteTask(deleteId, filter) {
        isEditTask = false;
        todos.splice(deleteId, 1);
        localStorage.setItem("todo-list", JSON.stringify(todos));
        showTodo(filter);
    }
    clearAll.addEventListener("click", () => {
        isEditTask = false;
        todos.splice(0, todos.length);
        localStorage.setItem("todo-list", JSON.stringify(todos));
        showTodo()
    });
    taskInput.addEventListener("keyup", e => {
        let userTask = taskInput.value.trim();
        if(e.key == "Enter" && userTask) {
            if(!isEditTask) {
                todos = !todos ? [] : todos;
                let taskInfo = {name: userTask, status: "pending"};
                todos.push(taskInfo);
            } else {
                isEditTask = false;
                todos[editId].name = userTask;
            }
            taskInput.value = "";
            localStorage.setItem("todo-list", JSON.stringify(todos));
            showTodo(document.querySelector("span.active").id);
        }
    });
    const isLeapYear = (year) => {
  return (
    (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) ||
    (year % 100 === 0 && year % 400 === 0)
  );
};
const getFebDays = (year) => {
  return isLeapYear(year) ? 29 : 28;
};
let calendar = document.querySelector('.calendar');
const month_names = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
  ];
let month_picker = document.querySelector('#month-picker');
const dayTextFormate = document.querySelector('.day-text-formate');
const timeFormate = document.querySelector('.time-formate');
const dateFormate = document.querySelector('.date-formate');

month_picker.onclick = () => {
  month_list.classList.remove('hideonce');
  month_list.classList.remove('hide');
  month_list.classList.add('show');
  dayTextFormate.classList.remove('showtime');
  dayTextFormate.classList.add('hidetime');
  timeFormate.classList.remove('showtime');
  timeFormate.classList.add('hideTime');
  dateFormate.classList.remove('showtime');
  dateFormate.classList.add('hideTime');
};

const generateCalendar = (month, year) => {
  let calendar_days = document.querySelector('.calendar-days');
  calendar_days.innerHTML = '';
  let calendar_header_year = document.querySelector('#year');
  let days_of_month = [
      31,
      getFebDays(year),
      31,
      30,
      31,
      30,
      31,
      31,
      30,
      31,
      30,
      31,
    ];

  let currentDate = new Date();

  month_picker.innerHTML = month_names[month];

  calendar_header_year.innerHTML = year;

  let first_day = new Date(year, month);


  for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {

    let day = document.createElement('div');

    if (i >= first_day.getDay()) {
      day.innerHTML = i - first_day.getDay() + 1;

      if (i - first_day.getDay() + 1 === currentDate.getDate() &&
        year === currentDate.getFullYear() &&
        month === currentDate.getMonth()
      ) {
        day.classList.add('current-date');
      }
    }
    calendar_days.appendChild(day);
  }
};

let month_list = calendar.querySelector('.month-list');
month_names.forEach((e, index) => {
  let month = document.createElement('div');
  month.innerHTML = `<div>${e}</div>`;

  month_list.append(month);
  month.onclick = () => {
    currentMonth.value = index;
    generateCalendar(currentMonth.value, currentYear.value);
    month_list.classList.replace('show', 'hide');
    dayTextFormate.classList.remove('hideTime');
    dayTextFormate.classList.add('showtime');
    timeFormate.classList.remove('hideTime');
    timeFormate.classList.add('showtime');
    dateFormate.classList.remove('hideTime');
    dateFormate.classList.add('showtime');
  };
});

(function() {
  month_list.classList.add('hideonce');
})();
document.querySelector('#pre-year').onclick = () => {
  --currentYear.value;
  generateCalendar(currentMonth.value, currentYear.value);
};
document.querySelector('#next-year').onclick = () => {
  ++currentYear.value;
  generateCalendar(currentMonth.value, currentYear.value);
};

let currentDate = new Date();
let currentMonth = { value: currentDate.getMonth() };
let currentYear = { value: currentDate.getFullYear() };
generateCalendar(currentMonth.value, currentYear.value);

const todayShowTime = document.querySelector('.time-formate');
const todayShowDate = document.querySelector('.date-formate');

const currshowDate = new Date();
const showCurrentDateOption = {
  year: 'numeric',
  month: 'long',
  day: 'numeric',
  weekday: 'long',
};
const currentDateFormate = new Intl.DateTimeFormat(
  'en-US',
  showCurrentDateOption
).format(currshowDate);
todayShowDate.textContent = currentDateFormate;
setInterval(() => {
  const timer = new Date();
  const option = {
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric',
  };
  const formateTimer = new Intl.DateTimeFormat('en-us', option).format(timer);
  let time = `${`${timer.getHours()}`.padStart(
      2,
      '0'
    )}:${`${timer.getMinutes()}`.padStart(
      2,
      '0'
    )}: ${`${timer.getSeconds()}`.padStart(2, '0')}`;
  todayShowTime.textContent = formateTimer;
}, 1000);
</script>
@endsection

<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
