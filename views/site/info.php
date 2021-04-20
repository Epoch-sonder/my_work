<?php

use yii\helpers\Html;


$this->title = 'Описание Модуля Ход выполнения работ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forest-work-index" style="padding: 0 5%;">

    <p>
        <?php //echo Html::a('Подробный отчет', ['summary-report-pol-detail'], ['class' => 'btn btn-success']) ?>
    </p>

	<div style="text-align: center; border-bottom: 1px solid #ccc; padding: .5rem;">Информационная система «Лесной кластер»</div>


	<h1 style="text-align: center; color: #58c">Информационная система «Лесной кластер»</h1><a name="forest-work"></a>

	<br><br>
	<p>Информационная система «Лесной кластер» предназначена для автоматизации учета сведений и отчетности о выполнении работ в области лесного планирования и проектирования.</p>
	<p>Доступ осуществляется посредством аутентификации пользователя по адресу <strong>https://cluster.lesreestr.ru</strong> путем ввода логина и пароля. Логин и пароль назначаются службой технической поддержки по предварительной заявке филиала о добавлении нового пользователя, которую нужно отправить на адрес электронной почты <strong>ladin.eg@roslesinforg.ru</strong>. В заявке должны содержаться следующие сведения:</p>
	<ul>
	    <li>название филиала,</li>
	    <li>фамилия, имя, отчество,</li>
	    <li>должность,</li>
	    <li>адрес электронной почты,</li>
	    <li>контактный телефон.</li>
	</ul>
	<p>В случае изменений в данных ответственного лица необходимо заполнить заявку от филиала на внесение таких изменений в системе, в которой должны быть указаны актуальные сведения по списку, приведенному выше.</p>
	<br>
	<p>При возникновении вопросов их следует направлять по адресу технической поддержки 
	<!-- <strong><a href="mailto:seminozhenko.ss@roslesinforg.ru">seminozhenko.ss@roslesinforg.ru</a></strong> -->
	<strong><a href="mailto:ladin.eg@roslesinforg.ru">ladin.eg@roslesinforg.ru</a></strong>. Перед отправкой вопроса следует ознакомиться с настоящей статьей, а также с <!--<strong><a href="/forest_work/forestwork/instruction-pol">-->Инструкциями<!--</a></strong>--> по предоставлению отчетности определенного модуля. В Инструкциях находится рубрика «Вопрос-ответ», в которой освещены часто задаваемые вопросы и даны ответы на них.</p>
	<p>Подготовка отчетов является обязательной еженедельной процедурой, формирование которой является важным инструментом планирования работы учереждения. В случае если по какой то причине передача отчетов по средствам информационной системы не окажется не возможно просьба сообщить об этом <strong><a href="mailto:ladin.eg@roslesinforg.ru">сотруднику технической поддержки</a></strong>.</p>

	<br>
	<p>Данное описание будет обновляться по мере расширения функционала и развития системы.</p>

<hr>

	<h2 style="text-align: center; color: #58c">Модуль "Лесное планирование" ("Ход работ")</h2><a name="report-pol"></a>
	
	<br>
	<p>Модуль предназначен для предоставления филиалами ФГБУ «Рослесинфорг» сведений о ходе выполнения работ в области лесного планирования и проектирования, отдельно по каждому договору (контракту), в разрезе видов документации лесного планирования и проектирования. Доступ к модулю осуществляется по средствам авторизации в информационной системе и выбора одноименной ссылки <strong><a href="/pd/pd-work">Ход работ</a></strong> расположенной в левой боковой панели системы.</p>

	<p>После успешной авторизации пользователю становятся доступны еженедельные отчеты по филиалу<sup style="color: #f00; font-weight: bold;" title="В зависимости от компетенции пользователей может быть предусмотрен расширенный функционал">*</sup>, отправленные ранее для ознакомления.</p>

	<p>Добавление новых сведений о количестве разрабатываемых (разработанных) проектов осовения лесов производится путем заполнения и отправки соответствующей формы в соответствии с <strong><a href="/pd/pd-work/instruction-pd">инструкцией</a></strong>.</p>

	<p>В целях учета объемов, выполняемых каждым филиалом, работ и своевременного принятия решений о возможных рисках и вариантов развития событий по исполнению догворов, форма отчетов заполняется по стадиям с указанием предполагаемых сроков окончания опредленной стадии работ.</p>
	
	<p>После успешной отправки отчета он появится в общем списке предоставленных отчетов. Любой отчет из этого списка можно открыть для просмотра, а также экспортировать в формате PDF для последующего сохранения в виде файла и печати.</p>

	<p>Для поиска проекта в общем списке предусмотрены функции сортировки и фильтрации по столбцам. По умолчанию при загрузке страницы отчеты отсортированы по времени сдачи. Кликом мыши на названии столбца можно применить сортировку по этому столбцу. Повторный клик по заголовку изменит направление сортировки (по возрастанию/по убыванию). Кроме того, существует возможность фильтрации записей путем ввода в поле фильтра (располагается сразу под заголовком столбца) сочетания символов, содержащегося в искомом названии. Так, для отображения всех записей по субъекту <em> например:«Краснодарский край»</em> в фильтре достаточно ввести часть искомого наименования <em> например:«красн»</em> и нажать клавишу ввода, на экране отобразится результат поиска.</p> 

	
<hr>
<!--
	<h2 style="text-align: center; color: #58c">Модуль "Отчеты о проектах освоения лесов"</h2><a name="report-pol"></a>
	
	<br>
	<p>Модуль предназначен для предоставления филиалами ФГБУ «Рослесинфорг» сведений о количестве проектов освоения лесов отдельно по каждому субъекту РФ, в разрезе видов использования лесов. Доступ к модулю осуществляется по средствам авторизации в информационной системе и выбора одноименной ссылки <strong><a href="/forest_work/forestwork">Отчеты ПОЛ</a></strong> расположенной в левой боковой панели системы.</p>

	<p>После успешной авторизации пользователю становятся доступны к ознакомлению еженедельные отчеты по филиалу<sup style="color: #f00; font-weight: bold;" title="В зависимости от компетенции пользователей может быть предусмотрен расширенный функционал">*</sup>, отправленные ранее.</p>

	<p>Добавление новых сведений о количестве разрабатываемых (разработанных) проектов осовения лесов производится путем заполнения и отправки соответствующей формы в соответствии с <strong><a href="/forest_work/forestwork/instruction-pol">инструкцией</a></strong>.</p>

	<p>В целях сокращения ошибок ввода, а также минимизации вводимой информации часть полей формы содержащая общую информацию о дате отчета, наименованию филиала и ответственного лица заполняются автоматически с использованием данных авторизованного лица, остальная часть полей выполнено в виде списков с фиксированными, выбираемыми значениями.</p>

	<p>В форме реализован механизм ускоренного заполнения, который позволяет не заполнять (оставлять пустыми) поля, показатели которых равны нулю. При отправке формы значение таких полей будут автоматически преобразованы в «0».</p>

	<p>После успешной отправки отчета он появится в общем списке предоставленных отчетов. Любой отчет из этого списка можно открыть для просмотра, а также экспортировать в формате PDF для последующего сохранения в виде файла и печати.</p>

	<p>Для поиска отчетов в общем списке предусмотрены функции сортировки и фильтрации по столбцам. По умолчанию при загрузке страницы отчеты отсортированы по времени сдачи. Кликом мыши на названии столбца можно применить сортировку по этому столбцу. Повторный клик по заголовку изменит направление сортировки (по возрастанию/по убыванию). Кроме того, существует возможность фильтрации записей путем ввода в поле фильтра (располагается сразу под заголовком столбца) сочетания символов, содержащегося в искомом названии. Так, для отображения всех записей по субъекту <em> например:«Краснодарский край»</em> в фильтре достаточно ввестичасть искомого наименования <em> например:«красн»</em> и нажать клавишу ввода, на экране отобразится результат поиска.</p> 

	<hr>
	<p><sup style="color: #f00; font-weight: bold;">*</sup> В зависимости от компетенции пользователей может быть предусмотрен расширенный функционал</p>
	<hr>


	<h2 style="text-align: center; color: #58c">Модуль "Проверки"</h2>
	<br>
	<p>Модуль «Проверки» состоит из двух блоков: «Переданные полномочия» и «Коллективные тренировки». </p>
	<p>Первый блок предназначен для контроля исполнения переданных полномочий в области лесных отношений органами исполнительной власти (ОИВ) субъектов РФ и состоит из нескольких компонентов: </p>
	<ul>
		<li>Тип проверки. Включены два базовых типа проверок: «плановая» и «внеплановая».</li>
		<li>Специалистов, которые привлекаются для проведения проверки. Указываются его Ф.И.О., должность, филиал ФГБУ «Рослесинфорг» и контактные данные (телефон и email).</li>
		<li>Сведения о проводимой проверке. Указываются даты начала и окончания, тип проверки, федеральный округ, субъект РФ и проверяемый орган исполнительной власти (выбирается из выпадающего списка), а также организатор проверки. После добавления проверки в режиме редактирования возможна загрузка документов в PDF-формате по нескольким категориям.</li>
		<li>Информация о ходе проверки. Здесь добавляются привлекаемые специалисты. Проверка выбирается из списка предварительно добавленных и идентифицируется по субъекту РФ и организатору проверки. Среди сведений указываются выявленные замечания и предложения, номер проверяемого раздела, а также финансовая составляющая по расходам.</li>
		<li>Сводной отчет за выбранный период с подсчетом числа проверок, привлеченных специалистов и суммарных расходов. Также автоматически подсчитываются расходы по каждой проверке и за каждый календарный месяц. Разработаны две дополнительные таблицы (свод по федеральным округам, свод по филиалам). В них отображается информация о проверках, специалистах и общей сумме расходов по федеральным округам и по филиалам.</li>
	</ul>
	<p>Блок «Коллективные тренировки» предназначен для контроля проведения тренировочных процессов, отслеживания их статуса и степени завершенности в соответствии с утвержденными датами. Филиалы организовывают и проводят коллективные тренировки для допуска специалистов к выполнению работ.</p>
	<p>Данный блок позволяет фиксировать:</p>
	<ul>
		<li>общую информацию о месте проведение работ, такую как субъект РФ, лесорастительный район, муниципальный район, лесничество;</li>
		<li>данные о тренировочном процессе. К ним относятся место проведения тренировки (лесничество, участковое лесничество, кварталы), даты тренировочного процесса, количество тренировочных площадок и т.д.;</li>
		<li>сведения о специалистах, проходящих тренировку. Подробная информация об участниках, их должности и месте работы находится в дополнительном блоке.</li>
	</ul>
	<p>В блоке предусмотрена загрузка документов в PDF-формате, которые являются основанием для проведения тренировки или подтверждают завершение определенных стадий (приказы, акты, ведомости). В качестве вспомогательных структур созданы блоки, содержащие информацию о лесорастительных зонах и районах и связанные с субъектами РФ и муниципальными районами.</p>
	


<p></p>

	

 
<hr>


	<h2 style="text-align: center; color: #58c">Сводный отчет ПОЛ</h2><a name="report-svodpol"></a>
	<div style="text-align: center; font-size: 1.7rem; color: #888;">краткая и подробная формы</div>

	<br><br>
	<p>Раздел предназначен для сотрудников ЦА ФГБУ «Рослесинфорг» в целях получения сводной информации о выполнении работ по разработке ПОЛ за текущую неделю по всем филиалам. Доступ к отчету осуществляется по ссылке <strong><a href="/forest_work/forestwork/summary-report-pol">Свод по ПОЛ</a></strong>. Сводные данные представлены в нескольких отчетных формах с разной степенью детализации. Отчеты генерируются в момент запроса на основе существующих данных за текущую и прошедшую неделю.</p>
	
	<p>При запросе отчета формируется <strong>краткая сводная форма</strong> с детализацией по субъектам и группировкой по филиалам. В нижней части таблицы автоматически расчитываются итоговые значения по столбцам. Динамическое раскрытие/скрытие подробной информации по субъектам филиала производится кликом мыши на названии филиала. Для визуального разделения главных и вложенных элементов использованы разные отступы. Вверху таблицы имеются управляющие элементы (<em>Развернуть все/Свернуть все</em>), позволяющие одним действием раскрыть/скрыть детальную информацию по всем филиалам.</p>

	<p>Рядом с названием каждого филиала предусмотрены маркеры, отражающие факт предоставления отчетов. Если отчет не предоставлен филиалом хотя бы по одному субъекту, появится соответствующее предупреждение (колокольчик). При наведении курсора мыши на маркер можно прочитать полный текст предупреждения.<br>
	Аналогичным образом реализованы предупреждения по каждому субъекту филиала внутри раскрытого списка.<br>
	При необходимости можно отключить отображение всех маркеров в таблице с помощью управляющего элемента <em>Маркеры</em> в верней части таблицы.</p>
	
	<p>В верхней части страницы расположена кнопка <strong>«Подробный отчет»</strong>, по нажатии на которую генерируется <strong>подробная сводная форма</strong> по видам использования лесов с детализацией по субъектам и группировкой по филиалам. В нижней части таблицы также автоматически расчитываются итоговые значения по столбцам, в правых столбцах таблицы - итоговые значения по строкам. Динамическое раскрытие/скрытие подробной информации по субъекту филиала производится кликом мыши на названии филиала. Вверху таблицы имеются управляющие элементы (Развернуть все/Свернуть все), позволяющие одним действием раскрыть/скрыть детальную информацию по всем филиалам. Для визуального разделения информации применяется цветовое выделение групп столбцов и строк. </p>

	<p>Вернуться к краткой сводной форме отчета можно с помощью нажатия кнопки <strong>«Краткий отчет»</strong> в верхней части страницы.</p>

	<p>Две представленные формы отчета дополняют друг друга, представляют информацию различной степени детализации и агрегации, а также позволяют отслеживать статус сдачи отчетности по филиалам и субъектам.</p>
-->
	<br>
	<!--<p>При возникновении вопросов их следует направлять по адресу технической поддержки <strong><a href="mailto:seminozhenko.ss@roslesinforg.ru">seminozhenko.ss@roslesinforg.ru</a></strong>.</p> -->



</div>