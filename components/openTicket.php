    <div class="me-2 py-3 col-sm-12 mb-2 border-bottom">
        <h3 class="text-primary text-opacity-75">New Ticket</h3>
        <hr class="bg-primary">
        <div class="form-floating mb-3">
            <p>Please select ticket type</p>
            <select class="form-select rounded border-primary" id="tipoEticket" title="Technical Support: These tickets are related to technical issues, such as problems with hardware, software, network connectivity, or other IT infrastructure.

Service/Feature Request: These tickets are for requests for a specific service, such as setting up a new workstation, installing new software, creating a new system feature or granting access to a system or resource.

Incident Report: These tickets are for reporting incidents that disrupt normal operations, such as system outages, security breaches, or data loss.

Change Request: These tickets are for requesting changes to existing systems or services, such as upgrading a software application, changing a network configuration, or modifying access permissions.

Problem Report: These tickets are for reporting recurring or persistent problems that need to be investigated and resolved.

Knowledge Request: These tickets are for requests for information or assistance, such as how to use a particular software feature, or the procedure for performing a specific task.">
                <option value="1">Technical Support</option>
                <option value="2">Service/Feature Request</option>
                <option value="3">Incident Report</option>
                <option value="4">Change Request</option>
                <option value="5">Problem Report</option>
                <option value="6">Knowledge Request</option>
            </select>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control rounded border-primary" id="asuntoEticket" type="text" placeholder="Issue">
            <label class="text-primary" for="asuntoEticket">Issue</label>
        </div>
        <div class="form-floating mb-3">
            <textArea class="border-primary form-control rounded h-100" id="detalleEticket" type="text" maxlength="512" rows="8" placeholder="Nombre"></textArea>
            <label class="text-primary" for="detalleEticket">Describe the issue</label>
            <span class="float-end my-n5 px-1 bg-primary rounded small text-white" id="count_message"></span>
        </div>
        <div class="w-100 text-end">
            <button type="button" class="btn btn-primary" id="btnSaveTicket">Open Ticket</button>
        </div>