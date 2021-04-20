<?php

use yii\helpers\Html;


$this->title = 'Описание Модуля ForestWork';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forest-work-index" style="padding: 0 5%;">

    <p class="pdf_but">
        <?= Html::a('К отчетам', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fas fa-file-pdf"></i> PDF', ['/pd/pd-work/instruction-pd-pdf'], [
            'class'=>'btn btn-danger', 
            'target'=>'_blank', 
            'data-toggle'=>'tooltip', 
            'title'=>'PDF-файл будет сгенерирован в новом окне'
        ]) ?>
    </p>

<!--<div style="text-align: center; border-bottom: 1px solid #ccc; padding: .5rem;">Единая централизованная информационная система «Лесной кластер»</div>-->
<h1 style="text-align: center; color: #58c">Инструкция</h1>
<div style="text-align: center; font-size: 1.5rem; color: #888;">по предоставлению отчетов о ходе выполнения работ</div>

<br><br>
<p>Отчет предоставляется путем заполнения и отправки одноименной формы в информационной системе «Лесной кластер» ответственным лицом филиала еженедельно не позднее 18:00 по МСК среды.</p>
<p>Отчет предоставляется отдельно по каждому субъекту Российской Федерации, находящемуся в зоне ответственности филиала ФГБУ «Рослесинфорг», либо иному субъекту по письменному согласованию с директором филиала, в зоне ответственности которого предполагается выполнение работ, и отдельно по каждому виду документации лесного планирования и проектирования, представленных в списке:</p>
<ul>
	    <li>Лесной план;</li>
	    <li>Лесохозяйственный регламент;</li>
	    <li>Проектная документация лесного участка(приказ МПР № 54);</li>
	    <li>Проект освоения лесов (ПОЛ);</li>
	    <li>Проект рекультивации нарушенных земель;</li>
	    <li>Лесная декларация;</li>
	    <li>Отчет об использовании лесов;</li>
	    <li>Проект лесовосстановления(лесоразведения);</li>
	    <li>Проект по изменению целевого назначения лесов (ст. 81 ЛК РФ);</li>
	    <li>Проект по проектированию особо защитных участков лесов;</li>
	    <li>Проект установления (изменения) границ лесопарковых и зеленых зон;</li>
	    <li>Установление лесопаркового зеленого пояса;</li>
	    <li>Проект планирования территории;</li>
	    <li>Проект межевания территории;</li>
	    <li>Перевод из состава земель лесного фонда;</li>
	    <li>Концепция инвестиционного проекта;</li>
	    <li>Проект противопожарного обустройства лесов;</li>
	    <li>Проект организации охотничьего хозяйства;</li>
	    <li>Проект организации территории ООПТ;</li>
	    <li>Проект реконструкции усадебного парка;</li>
	    <li>Проект оценки воздействия на окружающую среду (ОВОС);</li>
	    <li>Проект организации санитарно-защитной зоны;</li>
	    <li>Проект нормативов предельно допустимых выбросов (ПДВ);</li>
	    <li>Проект нормативов образования отходов и лимитов на их размещение (ПНООЛР);</li>
	    <li>Прочие проекты.</li>
	</ul>

<p><strong><span style="color: #f00;">Важно:</span> отчет необходимо предоставлять еженедельно не зависимо от того, произошли какие-либо изменения или нет. В случае несдачи отчетности за текущую неделю данные за прошлые периоды не будут автоматически приниматься как актуальные и не будут учтены в оперативных итоговых отчетах!</strong></p>
<p>Для создания отчета необходимо:</p>

<ol>
    <li>Авторизоваться в системе «Лесной кластер» используя логин и пароль (<em><a href="/forest_work/forestwork/info/#forestwork">как получить доступ к системе</a></em>). После успешной авторизации на боковой панели информационной системы появятся доступные для работы разделы;</li>
    <li>Перейти в раздел <strong><em><a href="/pd/pd-work">Ход работ</a></em></strong>. В таблице будут отображаться все отчеты по филиалу, находящиеся в работе. Для удобства они упорядочены по дате окончания договора;</li>
    <li>Нажать на кнопку <strong><em><a href="/pd/pd-work/create">"Создать проект"</a></em></strong> для заполнения формы <strong>Новая проектная документация</strong> и добавления отчетных данных;</li>
    <li>При обнаружении неактуальных данных, изменение которых не возможно пользователем, необходимо обратиться к <strong><a href="mailto:ladin.eg@roslesinforg.ru">сотруднику технической поддержки</a></strong>.</li>
    <li>Внести краткие сведения о договоре.</li>
    <li>Из выпадающего списка в поле <strong>«Наименование работ по проектированию»</strong> выбрать соответствующий документ.<br>
    В случае, когда в одном договре выполняется несколько видов проектных работ, необходимо отметить пункт <strong>«Работы выполняются в комплексе»</strong> и далее при начале формирования следующего вида документации, являющегося документом этого же контракта, необходимо будет отмечать этот пункт. При этом для каждого вида документации в одном контракте создается <strong>Новая проектная документация</strong> путем <strong><em><a href="/pd/pd-work/create">"Создать проект"</a></em></strong>.</li> 
    <li>В поле <strong>Основание выполнения работ</strong> указывается причина выполнения работ.</li> 
    <li>В поле <strong>Цели и обоснование</strong> указывается либо причина разработки документа (например: <strong>при изменени границ зеленых зон - не допустимость размещения объекта</strong>), либо вид использования лесов (например: <strong>при проектной документации лесного участка или проектов освоения лесов</strong>), либо иное описание причин или характеристик работ. Поле является обязательным к заполнению.</li>
    <li>Проверить правильность и полноту заполненых сведений и <strong>Сохранить</strong> создание проекта.</li>
    <li>После сохранения пользователь возращается на общую страницу <strong>Проектная документация</strong>, на которой поиск документации осуществляется путем заполнения полей фильтра. В фильтре достаточно ввести часть искомого наименования и нажать клавишу ввода, на экране отобразится результат поиска.</li>
    <li>При необходимости внесения изменений следует использовать режим редактирования <span style="color: #337ab7" class="glyphicon glyphicon-pencil"></span>.</li>
    <li>Переход к отчетам о ходе выполнения работ производится по нажатию на кнопку <strong>Процесс</strong> (<span style="color: #337ab7" class="glyphicon glyphicon-tasks"></span>) в столбце <strong>Действия</strong>.</li>
    <li>Вызов команды <span style="color: #337ab7" class="glyphicon glyphicon-tasks"></span>&nbsp;<strong>Процесс</strong> открывает страницу с отчетами о ходе выполнения работ, краткой информацией о проекте и договоре, а также формой добавления отчета. Еженедельные сведения о ходе выполнения работ заносятся в форму <strong>Добавления отчета</strong>.<br>
    В поле <strong>Объект</strong> вносится информация в отношении какого-либо объекта выполнения работ, например: <strong>Месторождение № 1</strong>.<br>
    В поле <strong>Стадия работ</strong> из выпадающего списка необходимо выбрать стадию, на которой находится выполнение работ.<br>
    В полях <strong>Дата начала и Дата окончания</strong> указываются даты начала этапа работ и планируемого окончания этапа работ.<br>
    В поле <strong>Описание выполнения работ</strong> подробно описывается состояние проекта на данном этапе на дату отчета, например: <strong>На планируемую дату не удалось получить заключение Росреестра, потому что специалист заболел, а другим проект не передали, ведутся переговоры с Заказчиком о продлении сроков</strong>.<br>При наличии документа, подтверждающего стадию проекта, следует загрузить его скан-копию с помощью кнопки <strong style="color: #337ab7"><em>"Выберите файл"</em></strong>. Загрузка файлов возможна в форматах <strong>doc</strong>/<strong>docx</strong>, <strong>xls</strong>/<strong>xlsx</strong> и <strong>pdf</strong>. </li>
    <li>После заполнения всех полей, необходимо проверить занесенную информацию и сохранить заполненый отчет, после этого он появится в полях записей расположенных ниже.</li>
    <li><p> После фактического  завершения работ необходимо поменять статус карточки на завершённый. Для этого следует отметить чек-бокс  <strong>Проект завершен и сдан заказчику</strong>, уточнить дату фактического завершения и нажать кнопку  <strong>Сохранить</strong>. После этого проект перейдет из категории в <strong><em><a href="/pd/pd-work/index">"В работе"</a></em></strong> в  <strong><em><a href="/pd/pd-work/index?completed=1">"Завершенные"</a></em></strong>.</p>
        <p>Также проект будет автоматически завершен после сдачи отчета на стадии <strong>Сдача-приемка работ Заказчику</strong>. </p></li>
</ol>

<br> <br>

   <br><br>
<p style="font-style: italic; color: #58c">Примечания:</p>
<ul>
    <li>После отправки отчета исправить его показатели нельзя.</li>
    <!--<li>При отправке более одного отчета за календарную неделю учитываться будет только последний.</li>-->
</ul>

<hr>
<br>
<p style="font-style: italic; color: #58c">Вопрос-ответ</p>

<p class="question"><strong>Вопрос:</strong> Что делать, если в выпадающем списке отсутствует субъект РФ, в границах которого выполняются работы? </p>
<p class="answer"><strong>Ответ:</strong> Напишите письмо в службу поддержки по адресу 
<!-- <strong><a href="mailto:seminozhenko.ss@roslesinforg.ru">seminozhenko.ss@roslesinforg.ru</a></strong> -->
<strong><a href="mailto:ladin.eg@roslesinforg.ru">ladin.eg@roslesinforg.ru</a></strong>
с просьбой добавить данный субъект в выпадающий список карточки вашего филиала.
Обратите вниманите на то, что после добавления нового субъкета РФ по нему необходимо предоставлять еженедельные данные наравне с другими субъектами РФ в зоне ответственности филиала.</p>

<!-- <p class="question"><strong>Вопрос:</strong> По некоторым субъектам РФ из списка не выполнялись работы в текущем году. Нужно ли по таким субъектам предоставлять отчет?</p>
<p class="answer"><strong>Ответ:</strong> Да, в этом случае отправляется нулевой отчет по субъекту РФ. Для отправки нулевого отчета можно оставить пустыми все поля, предназначенные для числовых значений. Необходимо выбрать субъект РФ из списка и нажать на кнопку "Отправить отчет" внизу формы.</p> -->

<!-- <p class="question"><strong>Вопрос:</strong> При заполнении данных отчета был выбран неправильный субъект РФ из списка. Что делать? Как исправить данную ситуацию?</p>
<p class="answer"><strong>Ответ:</strong> Фактически произошла отправка отчета по выбранному субъекту РФ с неправильными данными. Необходимо отправить еще один отчет по этому же субъекту РФ. В этом случае учитываться будет только последний отчет, отправленный в рамках календарной недели. Исправить уже отправленный отчет нельзя.</p> -->


</div>