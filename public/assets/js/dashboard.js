$(document).ready(function(){
    window.dashboardInstance = new Dashboard($('#dashboard'));
    window.dashboardInstance.loadGrid()
        .done(function(){
            window.dashboardInstance.bootstrap();
        });
});

class DashboardApi{
    static get baseUrl(){
        return "/api/v1/dashboard";
    }
    static fetch(){
        return $.get(this.baseUrl);
    }
    static store(data){
        // var finalJson = JSON.stringify(data, null, '    ');
        this.makeRequest("PUT", this.baseUrl, data)
            .done(function(){
                console.log("SUCCESS SAVING DASHBOARD");
            })
            .fail(function(){
                console.log("Fail SAVING DASHBOARD");
            })
    }

    static makeRequest(httpVerb, url, data){
        return $.ajax(url, {
            data : JSON.stringify(data, null, '    '),
            contentType : 'application/json',
            type : httpVerb
        });
    }
}

class Dashboard{
    constructor(elem) {
        this.domElem  = elem;
        this.api      = DashboardApi;
    }

    bootstrap(){
        this.bootstrap_eventHandlers();
        this.modalColorPicker = initColorPicker(".color-picker");
    }

    get grid(){
        return this.domElem.data('gridstack');
    }

    get nodeTemplate(){
        return $(`
            <div>
                <div class="grid-stack-item-content">
                    <h1 class="title" />
                    <i class="edit-item-action fas fa-bars"></i>
                </div>
            <div/>
        `);
    }

    bootstrap_eventHandlers(){
        var that = this;
        // Navbar actions
        $(".main-nav .nav-action [data-action]").each(function(){
            var elem = $(this);
            elem.click(function(){
                var methodName = 'action_' + elem.data('action');
                that[methodName]();
            })
        });
        
        // Widget modal
        var widgetModal = $("#modal-widget");
        widgetModal.find(".create-btn").click(function(){
            var bgColor = that.modalColorPicker.getColor().toHEXA().toString();
            var title   = widgetModal.find("input[name='title']").val()
            var params = {bgColor: bgColor, title: title};
            that.addWidget(params);
            $.modal.close();
        });

        widgetModal.find(".edit-btn").click(function(){
            var item = widgetModal.data("item");
            that.changeItemProperties(item, {
                title:   widgetModal.find("input[name='title']").val(),
                bgColor: that.modalColorPicker.getColor().toHEXA().toString()
            });
            that.saveGrid();
            $.modal.close();
        });

        widgetModal.find(".delete-btn").click(function(){
            var item = widgetModal.data("item");
            that.grid.removeWidget(item);
            $.modal.close();
        });

        // Grid events
        $('.grid-stack').on('change', function(event, items) {
            that.saveGrid();
        });


        // Edit item action
        $(document).on("click", ".grid-stack-item-content .edit-item-action", function(){
            var el = $(this).closest('.grid-stack-item');
            that.action_displayAddWidgetModal(el);
        })
    }

    changeItemProperties(item, params){
        item.find(".title").text(params.title)
        item.find('.grid-stack-item-content').css('background-color', params.bgColor);
    }
    
    loadGrid() {
        var that = this;
        return DashboardApi.fetch()
            .done(function(serializedData){
                var items = GridStackUI.Utils.sort(serializedData);
                _.each(items, function (node) {
                    this.grid.addWidget(this.prepareTemplate(this.nodeTemplate, node),
                        node.x, node.y, node.width, node.height);
                }, that);
            })
            .fail(function(){
                alert("There has been an error trying to fetch the dashboard data")
            });
    }

    saveGrid() {
        var serializedData = _.map($('.grid-stack > .grid-stack-item:visible'), function (el) {
            el = $(el);
            var node = el.data('_gridstack_node');
            return {
                x: node.x,
                y: node.y,
                width: node.width,
                height: node.height,
                title: el.find(".grid-stack-item-content .title").text(),
                bgColor: el.find(".grid-stack-item-content").css("background-color")
            };
        }, this);
        DashboardApi.store(serializedData);
        return false;
    }

    clearGrid() {
        this.grid.removeAll();
        return false;
    }

    addWidget(node){
        this.grid.addWidget(
            this.prepareTemplate(this.nodeTemplate, node),
            node.x, node.y, node.width, node.height, true
        );
    }

    prepareTemplate(template, params){
        var {title, bgColor} = params;
        var item = template.find('.grid-stack-item-content');
        item.css('background-color', bgColor);
        item.find(".title").text(title);
        return template;
    }

    setUpModal(itemToEdit){
        var that = this;
        var modal = $("#modal-widget");
        var mode = 'create';
        if(itemToEdit) mode = 'edit';

        modal.find(".action").hide();
        $(".field [name]").val(''); // Empty inputs
        that.modalColorPicker.setColor(`rgb(118,194,91)`); // Reset to color

        itemToEdit ? modal.data('item', itemToEdit) : modal.data('item', '');
        
        if(mode === 'create')
            modal.find(".create-btn").show();
        
        if(mode === 'edit'){
            var matches = itemToEdit.find(".grid-stack-item-content").css("background-color").match(/(\d+)/g);
            var r = matches[0]
            var g = matches[1]
            var b = matches[2];
            that.modalColorPicker.setColor(`rgb(${r}, ${g}, ${b})`);
            modal.find(".field [name='title']").val(itemToEdit.find(".title").text());
            modal.find(".edit-btn,.delete-btn").show();
        }
    }

    action_displayAddWidgetModal(itemToEdit){
        this.setUpModal(itemToEdit);
        
        // Display modal
        $("#modal-widget").modal({
            fadeDuration: 100
        });
    }
}

//////////////////
// Color picker //
//////////////////
function initColorPicker(elemSelector){
    const pickr = Pickr.create({
        el: elemSelector,
        theme: 'monolith', // or 'monolith', or 'nano'
    
        swatches: [
            'rgba(244, 67, 54, 1)',
            'rgba(233, 30, 99, 0.95)',
            'rgba(156, 39, 176, 0.9)',
            'rgba(103, 58, 183, 0.85)',
            'rgba(63, 81, 181, 0.8)',
            'rgba(33, 150, 243, 0.75)',
            'rgba(3, 169, 244, 0.7)',
            'rgba(0, 188, 212, 0.7)',
            'rgba(0, 150, 136, 0.75)',
            'rgba(76, 175, 80, 0.8)',
            'rgba(139, 195, 74, 0.85)',
            'rgba(205, 220, 57, 0.9)',
            'rgba(255, 235, 59, 0.95)',
            'rgba(255, 193, 7, 1)'
        ],
    
        components: {
    
            // Main components
            preview: true,
            opacity: true,
            hue: true,
    
            // Input / output Options
            interaction: {
                hex: true,
                rgba: true,
                hsla: true,
                hsva: true,
                cmyk: true,
                input: true,
                clear: true,
                save: true
            }
        }
    });
    return pickr;
}